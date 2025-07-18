@extends('adminlte::page') {{-- Cambiar a layout de AdminLTE --}}
@section('title', 'Ubicación') {{-- Título para pestaña del navegador --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar</title>
</head>
<body>
    @section('content_header') {{-- Sección específica de AdminLTE para el encabezado --}}
    <h1>Actualizar Ubicación</h1>
    <form method="POST" action="{{ route('ubicacion.update', ['idubicacion' => $ubicacion->idubicacion]) }}">     
        @csrf @method('PUT')
        <div class="col-6">
        <label>Codigo del Salon</label>
        <input type="text" name="codsalon" id="codsalon" class="form-control" value="{{ $ubicacion->codsalon }}" required>
        <br>
        <label>Dotación</label>
        <input type="text" name="dotacion" id="dotacion" class="form-control" value="{{ $ubicacion->dotacion }}" required>
        <br>
        <label>Estado</label>
        <input type="text" name="estado" id="estado" class="form-control" value="{{ $ubicacion->estado }}" required>
        <br>
        <input type="hidden" name="idubicacion" id="idubicacion" class="form-control" value="{{ $ubicacion->idubicacion }}">
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('ubicacion.index') }}" method="GET" class="btn btn-secondary">Regresar</a>
        </div>
        
    </form> 
</body>
</html>
@stop