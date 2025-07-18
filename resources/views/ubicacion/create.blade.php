@extends('adminlte::page') {{-- Cambiar a layout de AdminLTE --}}

@section('title', 'Ubicación') {{-- Título para pestaña del navegador --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear</title>
</head>

<body>
@section('content_header') {{-- Sección específica de AdminLTE para el encabezado --}}
    <h1>Crear Ubicación</h1>
    <form action="{{ route('ubicacion.store') }}" method="POST">     
        @csrf 
        <div class="col-6">
            <label for="codsalon">Codigo del Salon:</label>
            <input type="text" class="form-control" name="codsalon" id="codsalon" required>
            <br>
            <label for="dotacion">Dotación:</label>
            <input type="text" class="form-control" name="dotacion" id="dotacion" required>
            <br>
            <label for="estado">Estado:</label>
            <input type="text" class="form-control" name="estado" id="estado" required>
            <br>
            <button type="submit" class="btn btn-primary">Crear</button>
            <a href="{{ route('ubicacion.index') }}" method="GET" class="btn btn-secondary">Regresar</a>
        </div>
    </form> 
</body>
</html>
@stop