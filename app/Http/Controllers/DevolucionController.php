<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetallePrestamo;
use Illuminate\Support\Facades\DB;
use App\Models\Prestamos; 
use App\Models\Equipos;   
use App\Models\Docentes;
use Carbon\Carbon;


class DevolucionController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function pendientes(){

        $equiposPendientes = DetallePrestamo::with(['prestamo', 'equipo','prestamo.docente'
        ])->where('estado_detalle', 'Entregado')->whereHas('prestamo', function ($query){
            $query->where('estado', '!=','Finalizado')
                  ->where('estado','!=','Cancelado');
        })->get();

        return view('devoluciones.pendientes', compact('equiposPendientes'));
    }

     public function procesarDevolucion(Request $request)
    {
        // 1. Validar la entrada del array principal
        $request->validate([
            'devoluciones' => 'required|array',
        ], [
            'devoluciones.required' => 'Debe seleccionar al menos un equipo para procesar la devolución.',
        ]);

        // --- AJUSTE CRÍTICO: Filtrar solo los ítems que tienen un estado de devolución establecido ---
        $dataToProcess = collect($request->devoluciones)->filter(function ($item) {
            // Un ítem es válido para procesar si tiene iddetprestamo Y estado_detalle
            return isset($item['iddetprestamo']) && !empty($item['estado_detalle']);
        })->toArray();
        
        // Si después del filtro no queda nada, retornamos un error.
        if (empty($dataToProcess)) {
            return redirect()->back()->withInput()->with('error', 'Debe seleccionar un equipo Y establecer su Estado Final (Devuelto/Dañado) para procesar la devolución.');
        }

        // 2. Validar los datos filtrados (solo los completos)
        $validatedData = validator($dataToProcess, [
            '*.iddetprestamo' => 'required|exists:detalleprestamo,iddetprestamo',
            '*.estado_detalle' => 'required|in:Devuelto,Dañado',
            '*.observaciondevolucion' => 'nullable|string|max:255',
        ], [
            '*.estado_detalle.in' => 'El estado de devolución seleccionado no es válido.'
        ])->validate();


        DB::beginTransaction();

        try {
            $fechaDevolucionReal = Carbon::now();
            $prestamosAfectados = [];

            foreach ($validatedData as $dataDevolucion) {
                $detalle = DetallePrestamo::find($dataDevolucion['iddetprestamo']);

                if ($detalle) {
                    $detalle->update([
                        'estado_detalle' => $dataDevolucion['estado_detalle'],
                        'observaciondevolucion' => $dataDevolucion['observaciondevolucion'] ?? null,
                        'fecha_devolucion_real' => $fechaDevolucionReal,
                    ]);

                    if (!in_array($detalle->idprestamo, $prestamosAfectados)) {
                        $prestamosAfectados[] = $detalle->idprestamo;
                    }
                }
            }

            // 3. Revisar el estado del Préstamo principal
            foreach ($prestamosAfectados as $idPrestamo) {
                $equiposPendientes = DetallePrestamo::where('idprestamo', $idPrestamo)
                    ->where('estado_detalle', 'Entregado')
                    ->count();

                if ($equiposPendientes === 0) {
                    $prestamo = Prestamos::find($idPrestamo);
                    if ($prestamo) {
                        // Verificamos si hay detalles vencidos antes de finalizar
                        $equiposVencidos = DetallePrestamo::where('idprestamo', $idPrestamo)
                            ->where('estado_detalle', 'Vencido')
                            ->count();
                            
                        // Si todos están devueltos/dañados/vencidos, se finaliza el préstamo principal
                        if ($equiposVencidos > 0) {
                            $prestamo->update(['estado' => 'Vencido/Finalizado']);
                        } else {
                            $prestamo->update(['estado' => 'Finalizado']);
                        }
                    }
                }
            }
            
            DB::commit();
            
            return redirect()->route('devoluciones.pendientes')->with('success', 'Devolución de equipos procesada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error al procesar devolución: " . $e->getMessage()); 
            
            return redirect()->back()->withInput()->with('error', 'Error crítico en la base de datos: ' . $e->getMessage());
        }
    }
}
