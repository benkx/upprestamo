<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\Prestamos;
use App\Models\Docentes;
use App\Models\Ubicacion;
use App\Models\Usuarios;
use App\Models\Periodoacademico;
use App\Models\Detalleprestamo; // Assuming you have a model for Detalleprestamo
use App\Models\Equipos; // Assuming you have a model for Equipos
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;


class PrestamosController extends Controller
{
   
     public function __construct()
    {
        $this->middleware('auth');
    }

   
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
   

          $funcionarios = DB::connection('oracle')->select(
            "SELECT 
                NUMDOC, 
                NOMBRE1, 
                APELLIDO1, 
                LABORDOCENTE, 
                NOMBRE1 || ' ' || APELLIDO1 AS NOMBRE_COMPLETO 
             FROM ACADEMICO.V_FUNCIONARIOS 
             ORDER BY NOMBRE_COMPLETO"
        );
        #$periodoacademico = Periodoacademico::with('periodoacademico');
        $prestamos = Prestamos::with('ubicacion', 'periodoacademico', 'usuario','detalles')->get();
        
        //filtrar por estado si se envie el parametro
        $query = Prestamos::query();

        if($request->filled('estado')){
            $query->where('estado',$request->estado);
        }
        //ordenar por fecha de prestamo desc
         $query->orderBy('fechaprestamo', 'desc');
        
        //paginacion
           $prestamos= $query->paginate(10);

        return view('prestamos.index', compact('prestamos', 'funcionarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        #$docentes = Docentes::all();
        $ubicaciones = Ubicacion::all();
        // $usuarios = Usuarios::all();
        $periodoacademico = Periodoacademico::all();
        $equipos = Equipos::all(); // Assuming you have a model for Equipos
        #$detalleprestamo = Detalleprestamo::all(); // Assuming you have a model for Detalleprestamo

        // 2. Obtener la lista de funcionarios (Docentes) desde Oracle
        // NOTA: Reemplaza 'nombre_conexion_oracle' con el nombre real de tu conexión
        try {
            $funcionarios = DB::connection('oracle')
                ->table('academico.v_FUNCIONARIOS')
                ->select('NUMDOC', DB::raw("NOMBRE1 || ' ' || APELLIDO1 AS NOMBRE_COMPLETO"))
                ->orderBy('NOMBRE_COMPLETO')
                ->get();
        } catch (\Exception $e) {
            // Manejo de error si la conexión a Oracle falla
            $funcionarios = collect();
            session()->flash('error', 'Error al cargar los funcionarios desde Oracle: ' . $e->getMessage());
        }

        // 3. Obtener la lista de recursos físicos desde Oracle
        try {
            $recursos = DB::connection('oracle')
                ->table('academico.v_recursofisico')
                ->select('RECUSOFISICO', 'UBICACION')
                ->orderBy('UBICACION')
                ->get();
        } catch (\Exception $e) {
            // Manejo de error si la conexión a Oracle falla
            $recursos = collect();
            session()->flash('error', 'Error al cargar los recursos desde Oracle: ' . $e->getMessage());
        }

        return view('prestamos.create', compact('funcionarios', 'ubicaciones', 'periodoacademico','equipos', 'recursos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // CRÍTICO: Comprueba qué llega realmente del formulario
      #\Log::info('Datos del formulario:', $request->all());
      #dd($request->all());
        // 1. VALIDACIÓN SIMPLIFICADA
        $validated = $request->validate([
            // Préstamo Principal
           'iddocente' => 'required|string|max:50',
           'nomfuncionarios' => 'required|string|max:100',
            'idubicacion' => 'required|exists:ubicacion,idubicacion',
            'fechaprestamo' => 'required|date',
            #'fechadevolucion' => 'required|date|after_or_equal:fechaprestamo', // Fecha esperada de devolución
            'idperoacademico' => 'required|exists:periodoacademico,idperoacademico',
            'estado' => 'nullable|in:Activo,Vencido,Finalizado,Cancelado',
           

            // Eliminamos la validación de 'estado' del request, ya que lo fijaremos en 'Activo'
            
            // Detalles de Equipo
            'equipos' => 'required|array|min:1', 
            'equipos.*.idequipo' => 'required|exists:equipos,idequipo', 
            'equipos.*.observacionentrega' => 'nullable|string|max:100',
            'equipos.*.estado_detalle' => 'nullable|in:Entregado,Devuelto,Vencido,Dañado',
            // Eliminamos validaciones para fechas y estado_detalle del request, ya que se asignan
            // o se manejan en la devolución.
        ],
        // Mensajes de error personalizados (Simplificados)
        [
            'equipos.required' => 'Debes añadir al menos un equipo al préstamo.',
            'equipos.*.idequipo.required' => 'Cada equipo debe tener una selección.',
            #'fechadevolucion.after_or_equal' => 'La fecha de devolución no puede ser anterior a la fecha de préstamo.',
            'equipos.*.observacionentrega.max' => 'La observación de entrega no debe exceder los 100 caracteres.',
        ]);

            // dd([
            //    # 'idusuario' => Auth::user()->idusuario,
            //     'validated_data' => $validated,
            //   'fillable_prestamo' => (new Prestamos())->getFillable()
            // ]);
//  $currentUserId = Auth::check() ? Auth::user()->idusuario : null;

//         if (!$currentUserId) {
//             return redirect()->back()->withInput()->with('error', 'Error de autenticación. No se pudo obtener el ID del usuario.');
//         }
            
        // INICIO DE LA TRANSACCIÓN: Asegura la integridad de los datos
        DB::beginTransaction();

        
        try {
            // 2. CREAR EL PRÉSTAMO PRINCIPAL (Tabla 'prestamos')
            $prestamo = Prestamos::create([
                
                // CRÍTICO: Asignación segura del ID del usuario de la sesión
                #'idusuario' => Auth::user()->idusuario,
                
                // Campos provenientes del request
                // 'idusuario' => $currentUserId,
                'iddocente' => $validated['iddocente'],
                'nomfuncionarios' => $validated['nomfuncionarios'],
                'idubicacion' => $validated['idubicacion'],
                'fechaprestamo' => $validated['fechaprestamo'],
               # 'fechadevolucion' => $validated['fechadevolucion'],
                'idperoacademico' => $validated['idperoacademico'],
                
                // CRÍTICO: Forzamos el estado inicial
                'estado' => 'Activo',
            ]);

            // 3. CREAR DETALLES DEL PRÉSTAMO (Tabla 'detalleprestamo')
            foreach ($validated['equipos'] as $equipoDetalle) {
                DetallePrestamo::create([
                    'idprestamo' => $prestamo->idprestamo, 
                    'idequipo' => $equipoDetalle['idequipo'],
                    // Quitamos 'fechaentrega' y 'fechadevolucion' del detalle
                    
                    // Asignamos la observación si existe, sino, queda nulo/vacío
                    'observacionentrega' => $equipoDetalle['observacionentrega'] ?? null, 
                    
                    // Ya no viene del formulario; se maneja en la devolución
                    'observaciondevolucion' => null, 
                    #'estado_detalle' => $equipoDetalle['estado_detalle'], 
                    // CRÍTICO: Forzamos el estado inicial del detalle
                    'estado_detalle' => 'Entregado', 
                ]);
            }

            \Log::info('Datos del formulario:',  $prestamo->getAttributes());
            // 4. COMMIT: Si todo salió bien, guardamos los cambios
           DB::commit();

            return redirect()->route('prestamos.index')->with('success', 'Préstamo y sus detalles creados exitosamente. Estado inicial: Activo.');

        } catch (QueryException $e) {
            // CATCH ESPECÍFICO PARA ERRORES DE BASE DE DATOS (Clave Foránea, Null Constraint, etc.)
            DB::rollBack();
            Log::error("ERROR DE BASE DE DATOS EN PRÉSTAMO: " . $e->getMessage() . " - SQL: " . $e->getSql());
            \Log::info('Datos del formulario:',  $e->getMessage());
            // CRÍTICO: DETIENE LA EJECUCIÓN Y MUESTRA EL ERROR SQL EXACTO.
            dd('Error de Base de Datos (QueryException): ', $e->getMessage(), 'SQL fallido (si aplica): ', $e->getSql(), 'Código de Error: ', $e->getCode());
            
            return redirect()->back()->withInput()->with('error', 'Error de Base de Datos. La operación se revirtió. Consulta el log de Laravel.');

        } catch (\Exception $e) {
            // CATCH GENERAL (Para errores de PHP, o cualquier otra excepción)
            DB::rollBack();
            Log::error("ERROR GENERAL EN PRÉSTAMO: " . $e->getMessage() . " en línea " . $e->getLine() . " en archivo " . $e->getFile());
            
            // CRÍTICO: DETIENE LA EJECUCIÓN Y MUESTRA LA EXCEPCIÓN COMPLETA.
            dd('Error General (\Exception): ', $e->getMessage(), 'Archivo: ' . $e->getFile(), 'Línea: ' . $e->getLine());
            
            return redirect()->back()->withInput()->with('error', 'Error desconocido. Revisa el log de Laravel.');
            
        }
        
    }

    
    /**
     * Display the specified resource.
     */
    public function show(Prestamos $prestamo)
    {
        $prestamo->load('docente', 'ubicacion', 'periodoacademico', 'usuario', 'detalles.equipo');
        return view('prestamos.show', compact('prestamo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($idprestamo)
    {
        $prestamo = Prestamos::with('detalles')->findOrFail($idprestamo);
        
        #dd($prestamo->detalles);

        $docentes = Docentes::all();
        $ubicaciones = Ubicacion::all();
        // $usuarios = Usuarios::all();
        $equipos = Equipos::all();
        $periodoacademico = Periodoacademico::all();
        return view('prestamos.edit', compact('prestamo', 'docentes', 'ubicaciones', 'equipos','periodoacademico'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, $idprestamo)
    {
        $request->validate([
            'iddocente' => 'nullable|exists:docentes,iddocente',
            'idubicacion' => 'nullable|exists:ubicacion,idubicacion',
            'fechaprestamo' => 'required|date',
            // 'idusuario' => 'nullable|exists:usuarios,idusuario',
            'idperoacademico' => 'nullable|exists:periodoacademico,idperoacademico',
            'estado' => 'nullable|in:Activo,Vencido,Finalizado,Cancelado',
            #'estado' => 'nullable|string',
            'equipos' => 'required|array|min:1', // Debe haber al menos un equipo
            'equipos.*.iddetprestamo' => 'nullable|exists:detalleprestamo,iddetprestamo', // ID del detalle si ya existe
            'equipos.*.idequipo' => 'required|exists:equipos,idequipo',
            'equipos.*.fechaentrega' => 'required|date',
            'equipos.*.fechadevolucion' => 'nullable|date|after_or_equal:equipos.*.fechaentrega',
            'equipos.*.observacionentrega' => 'required|string|max:100',
            'equipos.*.observaciondevolucion' => 'required|string|max:100',
            'equipos.*.estado_detalle' => 'nullable|in:Entregado,Devuelto,Vencido,Dañado',
        ], [ 
            'equipos.required' => 'Debes añadir al menos un equipo al préstamo.',
            'equipos.*.idequipo.required' => 'Cada equipo debe tener una selección.',
            'equipos.*.fechaentrega.required' => 'La fecha de entrega del equipo es obligatoria.',
            'equipos.*.observacionentrega.required' => 'La observación de entrega es obligatoria.',
            'equipos.*.observaciondevolucion.required' => 'La observación de devolución es obligatoria.',
            'equipos.*.estado_detalle.required' => 'El estado del detalle del equipo es obligatorio.',
            'equipos.*.estado_detalle.in' => 'El estado del detalle del equipo no es válido.',
            // Agrega más mensajes personalizados según sea necesario
        ]);

        try {
            $prestamo = Prestamos::findOrFail($idprestamo);

            // 1. Actualizar los campos del préstamo principal
            $prestamo->update([
                'iddocente' => $request->iddocente,
                'idubicacion' => $request->idubicacion,
                'fechaprestamo' => $request->fechaprestamo,
                // 'idusuario' => $request->idusuario,
                'idperoacademico' => $request->idperoacademico,
                'estado' => $request->estado,
            ]);

            // 2. Sincronizar los detalles de los equipos
            $existingDetailIds = $prestamo->detalles->pluck('iddetprestamo')->toArray();
            $submittedDetailIds = [];

            foreach ($request->equipos as $equipoDetalle) {
                if (isset($equipoDetalle['iddetprestamo']) && $equipoDetalle['iddetprestamo']) {
                    // Actualizar detalle existente
                    $detalle = DetallePrestamo::findOrFail($equipoDetalle['iddetprestamo']);
                    $detalle->update([
                        'idequipo' => $equipoDetalle['idequipo'],
                        'fechaentrega' => $equipoDetalle['fechaentrega'],
                        'fechadevolucion' => $equipoDetalle['fechadevolucion'],
                        'observacionentrega' => $equipoDetalle['observacionentrega'],
                        'observaciondevolucion' => $equipoDetalle['observaciondevolucion'],
                        'estado_detalle' => $equipoDetalle['estado_detalle'],
                    ]);
                    $submittedDetailIds[] = $equipoDetalle['iddetprestamo'];
                } else {
                    // Crear nuevo detalle
                    $newDetail = DetallePrestamo::create([
                        'idprestamo' => $prestamo->idprestamo,
                        'idequipo' => $equipoDetalle['idequipo'],
                        'fechaentrega' => $equipoDetalle['fechaentrega'],
                        'fechadevolucion' => $equipoDetalle['fechadevolucion'],
                        'observacionentrega' => $equipoDetalle['observacionentrega'],
                        'observaciondevolucion' => $equipoDetalle['observaciondevolucion'],
                        'estado_detalle' => $equipoDetalle['estado_detalle'],
                    ]);
                    $submittedDetailIds[] = $newDetail->iddetprestamo;
                }
            }

            // 3. Eliminar detalles que fueron removidos del formulario
            $detailsToDelete = array_diff($existingDetailIds, $submittedDetailIds);
            if (!empty($detailsToDelete)) {
                DetallePrestamo::whereIn('iddetprestamo', $detailsToDelete)->delete();
            }

            // $prestamo->load('detalles');

            // $totalEquipos = $prestamo->detalles->count();
            // $equipoDevueltos = $prestamo->detalles->where('estado_detalle','devuelto')->count();

            // if($totalEquipos == 0){
            //     $prestamo->estado = 'Cancelado';

            // }elseif($equipoDevueltos === $totalEquipos){

            //     $prestamo->estado = 'Cancelado';

            // }elseif($equipoDevueltos > 0 && $equipoDevueltos < $totalEquipos){
                
            //     $prestamo->estado = 'Prestado parcial';

            // }else{

            //     $prestamo->estado = 'Prestado total0000000000';
            // }

            // $prestamo->save();


            return redirect()->route('prestamos.index')->with('success', 'Préstamo actualizado exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Hubo un error al actualizar el préstamo: ' . $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

