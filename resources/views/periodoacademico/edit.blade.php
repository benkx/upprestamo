@extends('adminlte::page') {{-- Cambiar a layout de AdminLTE --}}

@section('title', 'Periodo Academico') {{-- Título para pestaña del navegador --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar</title>
</head>
<body>
    @section('content_header') {{-- Sección específica de AdminLTE para el encabezado --}}
    <h1>Actualizar Periodo Academico</h1>
    <form method="POST" action="{{ route('periodoacademico.update', ['idperoacademico' => $periodoacademico->idperoacademico]) }}">     
        @csrf @method('PUT')
        <div class="col-6">
        <label>Descripción</label>
        <input type="text" class="form-control" name="descripcion" id="descripcion" value="{{ $periodoacademico->descripcion }}" required>
        <br>
        <label>Estado</label>
        <input type="text" class="form-control" name="estado" id="estado" value="{{ $periodoacademico->estado }}" required>
        <br>
        <input type="hidden" name="idperoacademico" id="idperoacademico" value="{{ $periodoacademico->idperoacademico }}">
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('periodoacademico.index') }}" method="GET" class="btn btn-secondary">Regresar</a>
        </div>
        
    </form> 
</body>
</html>
@stop