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
    <h1>Actualizar Usuarios</h1>
    <form method="POST" action="{{ route('usuarios.update', ['idusuario' => $usuario->idusuario]) }}">     
        @csrf @method('PUT')
        <div class="col-6">
        <label>Nombre de Usuarios</label>
        <input type="text" class="form-control" name="nomusuario" id="nomusuario" value="{{ $usuario->nomusuario }}" required>
        <br>
        <label>Contraseña</label>
        <input type="text" class="form-control" name="contrasena" id="contrasena" value="{{ $usuario->contrasena }}" required>
        <br>
        <label>Nombre Completo</label>
        <input type="text" class="form-control" name="nomcompleto" id="nomcompleto" value="{{ $usuario->nomcompleto }}" required>
        <br>
        <label>Estado</label>
        <input type="text" class="form-control" name="estado" id="estado" value="{{ $usuario->estado }}" required>
        <br>
        <input type="hidden" name="idusuario" id="idusuario" value="{{ $usuario->idusuario }}">
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('usuarios.index') }}" method="GET" class="btn btn-secondary">Regresar</a>
        </div>
        
    </form> 
</body>
</html>
@stop