<?php

namespace App\Http\Controllers;

use App\Models\Detalleprestamo;
use App\Models\Equipos; // Assuming you have a model for Equipos
use App\Models\Prestamos; // Assuming you have a model for Prestamos
use Illuminate\Http\Request;

class DetalleprestamoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $detalleprestamo = Detalleprestamo::all();
        return view('detalleprestamo.index', compact('detalleprestamo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $equipos = Equipos::all();
        $prestamos = Prestamos::all(); // Assuming you have a model for Prestamos
        return view('detalleprestamo.create', compact('equipos', 'prestamos'));
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'idprestamo' => 'required|exists:prestamos,idprestamo',
            'idequipo' => 'required|exists:equipos,idequipo',
        ]);

        $detalleprestamo = new Detalleprestamo();
        $detalleprestamo->idprestamo = $validated['idprestamo'];
        $detalleprestamo->idequipo = $validated['idequipo'];
        $detalleprestamo->save();

        return redirect()->route('detalleprestamo.index')->with('success', 'Detalle de préstamo creado exitosamente.');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
