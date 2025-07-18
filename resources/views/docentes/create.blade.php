@extends('adminlte::page') {{-- Cambiar a layout de AdminLTE --}}

@section('title', 'Docentes') {{-- Título para pestaña del navegador --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Docentes</title>
</head>
<body>
    @section('content_header') {{-- Sección específica de AdminLTE para el encabezado --}}
    <h1>Crear Docentes</h1>
    <form action="{{ route('docentes.store') }}" method="POST">     
        @csrf 
        <div class="col-6">
        <label for="numdocumento">Numero de documento:</label>
        <input type="text" class="form-control" name="numdocumento" id="numdocumento" required>
        <br>
        <label for="nomcompleto">Nombre Completo:</label>
        <input type="text" class="form-control" name="nomcompleto" id="nomcompleto" required>
        <br>
        <label for="vinculacion">Vinculación:</label>
        <input type="text" class="form-control" name="vinculacion" id="vinculacion" required>
        <br>
        <button type="submit" class="btn btn-primary">Crear</button>
        <a href="{{ route('docentes.index') }}" method="GET" class="btn btn-secondary">Regresar</a>
        </div>
    </form> 
</body>
</html>
@stop