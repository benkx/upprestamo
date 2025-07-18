<?php

namespace App\Http\Controllers;

use App\Models\Docentes;
use Illuminate\Http\Request;

class DocentesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $docentes = Docentes::all();
        return view('docentes.index', compact('docentes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('docentes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de datos
        $validated = $request->validate([
            'numdocumento' => 'required|string|max:15',
            'nomcompleto' => 'required|string|max:255',
            'vinculcion' => 'nullable|boolean',
        ]);

        $docentes = new Docentes();
        $docentes->numdocumento = $validated['numdocumento'];
        $docentes->nomcompleto = $validated['nomcompleto'];
        $docentes->vinculacion = $validated['vinculacion'] ?? false;
        $docentes->save();
        // dd("this is save");
        return redirect()->route('docentes.index')->with('success', 'Docente creado con éxito');
        

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('docentes.show', compact('docentes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Docentes $docente)
    {
        // dd($docente);
        return view('docentes.edit', compact('docente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Docentes $docente)
    {
        $validated = $request->validate([
            // 'numdocumento' => 'required|integer|max:15',
            'nomcompleto' => 'required|string|max:255',
            'vinculacion' => 'nullable|boolean',
        ]);
        
        // $docentes = Docentes::find($docentes->iddocente);
        // $docente->numdocumento = $validated['numdocumento'];
        $docente->nomcompleto = $validated['nomcompleto'];
        $docente->vinculacion = $validated['vinculacion'] ?? null;
        $docente->save();
        return redirect()->route('docentes.index')->with('success', 'Docente actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $docentes = Docentes::find($id);
        $docentes->delete();
        return redirect()->route('docentes.index')->with('success', 'Docente eliminado con éxito');
    }
}
