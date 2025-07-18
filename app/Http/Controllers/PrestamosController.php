<?php
namespace App\Http\Controllers;

use App\Models\Prestamos;
use App\Models\Docentes;
use App\Models\Ubicacion;
use App\Models\Usuarios;
use App\Models\Periodoacademico;
use App\Models\Detalleprestamo; // Assuming you have a model for Detalleprestamo
use App\Models\Equipos; // Assuming you have a model for Equipos
use Illuminate\Http\Request;

class PrestamosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        #$periodoacademico = Periodoacademico::with('periodoacademico');
        $prestamos = Prestamos::with('docente', 'ubicacion', 'periodoacademico', 'usuario')->get();
        return view('prestamos.index', compact('prestamos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $docentes = Docentes::all();
        $ubicaciones = Ubicacion::all();
        $usuarios = Usuarios::all();
        $periodoacademico = Periodoacademico::all();
        $equipos = Equipos::all(); // Assuming you have a model for Equipos
        #$detalleprestamo = Detalleprestamo::all(); // Assuming you have a model for Detalleprestamo
      
        return view('prestamos.create', compact('docentes', 'ubicaciones', 'usuarios', 'periodoacademico','equipos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            
            'iddocente' => 'required|exists:docentes,iddocente', // Assuming iddocente is a string, adjust as necessary
            'idubicacion' => 'required|exists:ubicacion,idubicacion', // Assuming idubicacion is a string, adjust as necessary
            'fechaprestamo' => 'required|date',
            'fechadevolucion' => 'required|date',
            'idusuario' => 'required|exists:usuarios,idusuario', // Assuming idusuario is a string, adjust as necessary
            'idperoacademico' => 'required|exists:periodoacademico,idperoacademico', // Assuming idperiodoacademico is a string, adjust as necessary
            'estado' => 'nullable|in:Prestamo total,Prestamo parcial,Vencido,Finalizado',
            'equipos' => 'required|array|min:1', // Assuming equipos is an array of equipment IDs
            'equipos.*.idequipo' => 'required|exists:equipos,idequipo', // Validate each equipo ID
            'equipos.*.fechaentrega' => 'required|date',
            'equipos.*.fechadevolucion' => 'nullable|date|after_or_equal:equipos.*.fechaentrega', // `fechadevolucion` en `detalleprestamo`
            'equipos.*.observacionentrega' => 'nullable|string|max:100',
            'equipos.*.observaciondevolucion' => 'nullable|string|max:100',
            'equipos.*.estado_detalle' => 'nullable|in:Entregado,Devuelto',
        ],
        [
            'equipos.required' => 'Debes añadir al menos un equipo al préstamo.',
            'equipos.*.idequipo.required' => 'Cada equipo debe tener una selección.',
            'equipos.*.fechaentrega.required' => 'La fecha de entrega del equipo es obligatoria.',
            'equipos.*.fechaentrega.date' => 'La fecha de entrega del equipo debe ser una fecha válida.',
            'equipos.*.fechadevolucion.date' => 'La fecha de devolución del equipo debe ser una fecha válida.',
            'equipos.*.fechadevolucion.after_or_equal' => 'La fecha de devolución del equipo no puede ser anterior a la fecha de entrega.',
            'equipos.*.observacionentrega.required' => 'La observación de entrega es obligatoria.',
            'equipos.*.observacionentrega.string' => 'La observación de entrega debe ser texto.',
            'equipos.*.observacionentrega.max' => 'La observación de entrega no debe exceder los 100 caracteres.',
            'equipos.*.observaciondevolucion.required' => 'La observación de devolución es obligatoria.',
            'equipos.*.observaciondevolucion.string' => 'La observación de devolución debe ser texto.',
            'equipos.*.observaciondevolucion.max' => 'La observación de devolución no debe exceder los 100 caracteres.',
            'equipos.*.estado_detalle.required' => 'El estado del detalle del equipo es obligatorio.',
            'equipos.*.estado_detalle.in' => 'El estado del detalle del equipo no es válido.',
        ]);


        // foreach ($request->detalleprestamo as $detalle) {
        //     $detalleprestamo = new Detalleprestamo();
        //     $detalleprestamo->idprestamo = $detalle['idprestamo'];
        //     $detalleprestamo->idequipo = $detalle['idequipo'];
        //     $detalleprestamo->save(); // Guardar en BD
        // }

        // Crear el registro del préstamo principal
        try {
            $prestamo = Prestamos::create([
                'iddocente' => $request->iddocente,
                'idubicacion' => $request->idubicacion,
                'fechaprestamo' => $request->fechaprestamo,
                'fechadevolucion' => $request->fechadevolucion, // Esta es la fecha de devolución del préstamo general
                'idusuario' => $request->idusuario,
                'idperoacademico' => $request->idperoacademico,
                'estado' => $request->estado,
            ]);

            foreach ($request->equipos as $equipoDetalle) {
                DetallePrestamo::create([
                    'idprestamo' => $prestamo->idprestamo, // Usa el ID del préstamo recién creado
                    'idequipo' => $equipoDetalle['idequipo'],
                    'fechaentrega' => $equipoDetalle['fechaentrega'],
                    'fechadevolucion' => $equipoDetalle['fechadevolucion'],
                    'observacionentrega' => $equipoDetalle['observacionentrega'],
                    'observaciondevolucion' => $equipoDetalle['observaciondevolucion'],
                    'estado_detalle' => $equipoDetalle['estado_detalle'],
                ]);
            }

            return redirect()->route('prestamos.index')->with('success', 'Préstamo y sus detalles creados exitosamente.');

        } catch (\Exception $e) {
            // Manejo de errores, por ejemplo, loggear el error o devolver un mensaje al usuario
            return redirect()->back()->withInput()->with('error', 'Hubo un error al crear el préstamo: ' . $e->getMessage());
        }

        // $prestamos = new Prestamos();
        // $prestamos->iddocente = $validated['iddocente'];
        // $prestamos->idubicacion = $validated['idubicacion'];
        // $prestamos->fechaprestamo = $validated['fechaprestamo'];
        // $prestamos->fechadevolucion = $validated['fechadevolucion'];
        // $prestamos->idusuario = $validated['idusuario'];
        // $prestamos->idperoacademico = $validated['idperoacademico'];
        // $prestamos->estado = $validated['estado'];
        // $prestamos->save(); // Guardar en BD
      

        // return redirect()->route('prestamos.index')->with('success', 'Préstamo creado con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $usuarios = Usuarios::all();
        $equipos = Equipos::all();
        $periodoacademico = Periodoacademico::all();
        return view('prestamos.edit', compact('prestamo', 'docentes', 'ubicaciones', 'usuarios', 'equipos','periodoacademico'));
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
            'fechadevolucion' => 'nullable|date|after_or_equal:fechaprestamo',
            'idusuario' => 'nullable|exists:usuarios,idusuario',
            'idperoacademico' => 'nullable|exists:periodoacademico,idperoacademico',
            'estado' => 'nullable|in:Prestamo total,Prestamo parcial,Vencido,Finalizado',
            'equipos' => 'required|array|min:1', // Debe haber al menos un equipo
            'equipos.*.iddetprestamo' => 'nullable|exists:detalleprestamo,iddetprestamo', // ID del detalle si ya existe
            'equipos.*.idequipo' => 'required|exists:equipos,idequipo',
            'equipos.*.fechaentrega' => 'required|date',
            'equipos.*.fechadevolucion' => 'nullable|date|after_or_equal:equipos.*.fechaentrega',
            'equipos.*.observacionentrega' => 'required|string|max:100',
            'equipos.*.observaciondevolucion' => 'required|string|max:100',
            'equipos.*.estado_detalle' => 'nullable|in:Entregado,Devuelto',
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
                'fechadevolucion' => $request->fechadevolucion,
                'idusuario' => $request->idusuario,
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

