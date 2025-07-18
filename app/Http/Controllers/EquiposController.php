<?php

namespace App\Http\Controllers;

use App\Models\Equipos;
use Illuminate\Http\Request;

class EquiposController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $equipos = Equipos::all();
        return view('equipos.index', compact('equipos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('equipos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de datos
        $validated = $request->validate([
            'descripcion' => 'required|string|max:255',
            'codequipo' => 'required|string|max:255',
            'numserial' => 'required|string|max:255',
            'tipoequipo' => 'required|string|max:255',
            'estado' => 'nullable|in:Disponible,Ocupado,Mantenimiento,Inactivo',
        ]);

        $equipos = new Equipos();
        $equipos->descripcion = $validated['descripcion'];
        $equipos->codequipo = $validated['codequipo'];
        $equipos->numserial = $validated['numserial'];
        $equipos->tipoequipo = $validated['tipoequipo'];
        $equipos->estado = $validated['estado'] ?? null; // Manejo explícito de null
        $equipos->save(); // Guardar en BD

        return redirect()->route('equipos.index')->with('success', 'Equipo creado con éxito');
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
    public function edit(Equipos $equipo)
    {
        return view('equipos.edit', compact('equipo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Equipos $equipo)
    {
        // Validación de datos
        $validated = $request->validate([
            'descripcion' => 'required|string|max:255',
            'codequipo' => 'required|string|max:255',
            'numserial' => 'required|string|max:255',
            'tipoequipo' => 'required|string|max:255',
            'estado' => 'nullable|in:Disponible,Ocupado,Mantenimiento,Inactivo',
        ]);

        #$equipos = Equipos::findOrFail($id);
        $equipo->descripcion = $validated['descripcion'];
        $equipo->codequipo = $validated['codequipo'];
        $equipo->numserial = $validated['numserial'];
        $equipo->tipoequipo = $validated['tipoequipo'];
        $equipo->estado = $validated['estado'] ?? null; // Manejo explícito de null
        $equipo->save(); // Guardar en BD

        return redirect()->route('equipos.index')->with('success', 'Equipo actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $equipo = Equipos::findOrFail($id);
        $equipo->delete();

        return redirect()->route('equipos.index')->with('success', 'Equipo eliminado con éxito');
    }
}
