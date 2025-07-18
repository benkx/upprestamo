<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = Usuarios::all();
        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de datos
        $validated = $request->validate([
            'nomusuario' => 'required|string|max:255',
            'contrasena' => 'required|string|max:255',
            'nomcompleto' => 'required|string|max:255',
            'estado' => 'nullable|in:Activo,Inactivo',
        ]);

        $usuarios = new Usuarios();
        $usuarios->nomusuario = $validated['nomusuario'];
        $usuarios->contrasena = bcrypt($validated['contrasena']); // Encriptar la contraseña
        $usuarios->nomcompleto = $validated['nomcompleto'];
        $usuarios->estado = $validated['estado'] ?? null; // Manejo explícito de null
        $usuarios->save(); // Guardar en BD

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado con éxito');
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
    public function edit(Usuarios $usuario)
    {
        #dd($usuario);
        return view('usuarios.edit', compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Usuarios $usuario)
    {
        // Validación de datos
        $validated = $request->validate([
            'nomusuario' => 'required|string|max:255',
            'contrasena' => 'required|string|max:255',
            'nomcompleto' => 'required|string|max:255',
            'estado' => 'nullable|in:Activo,Inactivo',
        ]);

        // $usuarios = Usuarios::findOrFail($idusuario);
        #dd($usuarios);
        $usuario->nomusuario = $validated['nomusuario'];
        $usuario->contrasena = bcrypt($validated['contrasena']); // Encriptar la contraseña
        $usuario->nomcompleto = $validated['nomcompleto'];
        $usuario->estado = $validated['estado'] ?? null; // Manejo explícito de null
        $usuario->save(); // Guardar en BD

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $usuario = Usuarios::find($id);
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado con éxito');
    }
}
