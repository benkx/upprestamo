<?php

namespace App\Http\Controllers;

use App\Models\Solimantenimiento;
use App\Models\Equipos;
use App\Models\Usuarios;
use Illuminate\Http\Request;

class SolimantenimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $solimantenimiento = Solimantenimiento::all();
        return view('solimantenimiento.index', compact('solimantenimiento'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $equipos = Equipos::all();
        $usuarios = Usuarios::all();
        return view('solimantenimiento.create', compact('equipos', 'usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fechasolicitud' => 'required|date',
            'idequipo' => 'required|string|max:255', // Assuming idequipo is a string, adjust as necessary
            'descripcion' => 'required|string|max:1000',
            'fechacierre' => 'required|date',
            'idusuario' => 'required|string', // Assuming idusuario is a string, adjust as necessary
            'estado' => 'required|string|max:255',
        ]);
        $solimantenimiento = new Solimantenimiento();
       
        $solimantenimiento->fechasolicitud = $validated['fechasolicitud'];
        $solimantenimiento->idequipo = $validated['idequipo'];
        $solimantenimiento->descripcion = $validated['descripcion'];
        $solimantenimiento->fechacierre = $validated['fechacierre'];
        $solimantenimiento->idusuario = $validated['idusuario'];
        $solimantenimiento->estado = $validated['estado'];
        $solimantenimiento->save(); // Guardar en BD
 

        return redirect()->route('solimantenimiento.index')->with('success', 'Solicitud de mantenimiento creada con éxito.');
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
    public function edit(Solimantenimiento $solimantenimiento)
    {
        $equipos = Equipos::all();
        $usuarios = Usuarios::all();
        return view('solimantenimiento.edit', compact('solimantenimiento', 'equipos', 'usuarios'));
    }
   
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Solimantenimiento $solimantenimiento)
    {
        $validated = $request->validate([
            'fechasolicitud' => 'required|date',
            'idequipo' => 'required|string|max:255', // Assuming idequipo is a string, adjust as necessary
            'descripcion' => 'required|string|max:1000',
            'fechacierre' => 'required|date',
            'idusuario' => 'required|string', // Assuming idusuario is a string, adjust as necessary
            'estado' => 'required|string|max:255',
        ]);

       # $solimantenimiento = Solimantenimiento::findOrFail($id);
        $solimantenimiento->fechasolicitud = $validated['fechasolicitud'];
        $solimantenimiento->idequipo = $validated['idequipo'];
        $solimantenimiento->descripcion = $validated['descripcion'];
        $solimantenimiento->fechacierre = $validated['fechacierre'];
        $solimantenimiento->idusuario = $validated['idusuario'];
        $solimantenimiento->estado = $validated['estado'];
        $solimantenimiento->save(); // Guardar en BD

        return redirect()->route('solimantenimiento.index')->with('success', 'Solicitud de mantenimiento actualizada con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $solimantenimiento = Solimantenimiento::find($id);
        $solimantenimiento->delete();

        return redirect()->route('solimantenimiento.index')->with('success', 'Solicitud de mantenimiento eliminada con éxito.');
    }
}
