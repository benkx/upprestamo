<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Periodoacademico;

class PeriodoacademicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $periodoacademico = Periodoacademico::all();
        // dd($periodoacademico);
        return view('periodoacademico.index', compact('periodoacademico'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('periodoacademico.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $validated = $request->validate([
            'descripcion' => 'required',
            'estado' => 'nullable|in:Activo,Cerrado',
            
        ]);

        $periodoacademico = new Periodoacademico();
        $periodoacademico->descripcion = $validated['descripcion'];
        $periodoacademico->estado = $validated['estado'] ?? null; // Manejo explícito de null
        $periodoacademico->save();

        return redirect()->route('periodoacademico.index')->with('success', 'Periodo Academico creado exitosamente.');
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
    public function edit(Periodoacademico $periodoacademico)
    {
        return view('periodoacademico.edit', compact('periodoacademico'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Periodoacademico  $periodoacademico)
    {
        $validated = $request->validate([
            'descripcion' => 'required',
            'estado' => 'nullable|in:Activo,Cerrado',
        ]);

        #$periodoacademico = Periodoacademico::findOrFail($id);
        $periodoacademico->descripcion = $validated['descripcion'];
        $periodoacademico->estado = $validated['estado'] ?? null; // Manejo explícito de null
        $periodoacademico->save();

        return redirect()->route('periodoacademico.index')->with('success', 'Periodo Academico actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $periodoacademico = Periodoacademico::find($id);
        $periodoacademico->delete();

        return redirect()->route('periodoacademico.index')->with('success', 'Periodo Academico eliminado exitosamente.');
    }
}
