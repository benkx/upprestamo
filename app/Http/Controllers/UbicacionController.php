<?php

namespace App\Http\Controllers;

use App\Models\Ubicacion;
use Illuminate\Http\Request;

class UbicacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ubicacion = Ubicacion::all();
        return view('ubicacion.index', compact('ubicacion'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ubicacion.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        // Validación de datos
    $validated = $request->validate([
        'codsalon' => 'required|string|max:255',
        'dotacion' => 'required|string|max:255', 
        'estado' => 'nullable|in:Disponible,No Disponible',
    ]);

    
        $ubicacion = new Ubicacion();
        $ubicacion->codsalon = $validated['codsalon'];  // Usar datos validados
        $ubicacion->dotacion = $validated['dotacion'];
        $ubicacion->estado = $validated['estado'] ?? null; // Manejo explícito de null
        $ubicacion->save(); // Guardar en BD

        return redirect()->route('ubicacion.index')->with('success', 'Ubicación creada con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ubicacion $ubicacion)
    {
        
        // $ubicacion = Ubicacion::findOrFail($idubicacion);
        return view('ubicacion.show', compact('ubicacion'));
   
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ubicacion $ubicacion)
    {
        return view('ubicacion.edit', compact('ubicacion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ubicacion $ubicacion)
    {
        // Validación de datos
        $validated = $request->validate([
            'codsalon' => 'required|string|max:255',
            'dotacion' => 'required|string|max:255',
            'estado' => 'nullable|in:Disponible,No Disponible',
        ]);

        //$ubicacion = Ubicacion::findOrFail($ubicacion);
        $ubicacion->codsalon = $validated['codsalon'];
        $ubicacion->dotacion = $validated['dotacion'];
        $ubicacion->estado = $validated['estado'] ?? null;
        $ubicacion->save();

        return redirect()->route('ubicacion.index')->with('success', 'Ubicación actualizada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ubicacion = Ubicacion::find($id);
        $ubicacion->delete();
        return redirect()->route('ubicacion.index')->with('success', 'Ubicación eliminada con éxito');
    }
}
