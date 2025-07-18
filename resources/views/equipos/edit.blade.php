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
    <h1>Actualizar Equipos</h1>
    <form method="POST" action="{{ route('equipos.update', ['idequipo' => $equipo->idequipo]) }}">     
        @csrf @method('PUT')
        <label>Descripción</label>
        <input type="text" class="form-control" name="descripcion" id="descripcion" value="{{ $equipo->descripcion }}" required>
        <br>
        <label>Codigo del Equipo</label>
        <input type="text" class="form-control" name="codequipo" id="codequipo" value="{{ $equipo->codequipo }}" required>
        <br>
        <label>Numero Serial</label>
        <input type="text" class="form-control" name="numserial" id="numserial" value="{{ $equipo->numserial }}" required>
        <br>
        <label>Tipo de Equipo</label>
        <input type="text" class="form-control" name="tipoequipo" id="tipoequipo" value="{{ $equipo->tipoequipo }}" required>
        <br>
        <label>Estado</label>
        <input type="text" class="form-control" name="estado" id="estado" value="{{ $equipo->estado }}" required>
        <br>
        <input type="hidden" name="idequipo" id="idequipo" value="{{ $equipo->idequipo }}">
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('equipos.index') }}" method="GET" class="btn btn-secondary">Regresar</a>

        
    </form> 
</body>
</html>
@stop