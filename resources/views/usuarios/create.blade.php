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
    <h1>Crear Usuario</h1>
    <form action="{{ route('usuarios.store') }}" method="POST">     
        @csrf 
        <div class="col-6">
        <label for="nomusuario">Nombre de usuario:</label>
        <input type="text" class="form-control" name="nomusuario" id="nomusuario" required>
        <br>
        <label for="contrasena">Contraseña:</label>
        <input type="text" class="form-control" name="contrasena" id="contrasenas" required>
        <br>
        <label for="nomcompleto">Nombre Completo:</label>
        <input type="text" class="form-control" name="nomcompleto" id="nomcompleto" required>
        <br>
        <label for="estado">Estado:</label>
        <input type="text" class="form-control" name="estado" id="estado" required>
        <br>
        <button type="submit" class="btn btn-primary">Crear</button>
        <a href="{{ route('usuarios.index') }}" method="GET" class="btn btn-secondary">Regresar</a>
        </div>
    </form> 
</body>
</html>
@stop