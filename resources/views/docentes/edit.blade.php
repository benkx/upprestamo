@extends('adminlte::page') {{-- Cambiar a layout de AdminLTE --}}

@section('title', 'Docentes') {{-- Título para pestaña del navegador --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar</title>
</head>
<body>
    @section('content_header') {{-- Sección específica de AdminLTE para el encabezado --}}
    <h1>Actualizar Docentes</h1>
    <form method="POST" action="{{ route('docentes.update', ['iddocente' => $docente->iddocente]) }}">     
        @csrf @method('PUT')
        <div class="col-6">
        <label>Numero de documento</label>
        <input type="text" class="form-control" name="numdocumento" id="numdocumento" value="{{ $docente->numdocumento }}" disabled>
        <br>
        <label>Nombre Completo</label>
        <input type="text" class="form-control" name="nomcompleto" id="nomcompleto" value="{{ $docente->nomcompleto }}" required>
        <br>
        <label>Vinculado</label>
        <input type="text" class="form-control" name="vinculacion" id="vinculacion" value="{{ $docente->vinculacion }}" required>
        <br>
        <input type="hidden" name="iddocente" id="iddocente" value="{{ $docente->iddocente }}">
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('docentes.index') }}" method="GET" class="btn btn-secondary">Regresar</a>
        </div>
        
    </form> 
</body>
</html>
@stop