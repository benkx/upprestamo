@extends('adminlte::page') {{-- Cambiar a layout de AdminLTE --}}

@section('title', 'Periodo Academico') {{-- Título para pestaña del navegador --}}

@section('content_header') {{-- Sección específica de AdminLTE para el encabezado --}}
    <h1>Periodo Academico
        <a href="{{ route('periodoacademico.create') }}" class="btn btn-success btn-sm">
            <i class="fas fa-plus-circle"></i> Nuevo
        </a>
    </h1>
@stop

@section('content') {{-- Contenido principal debe usar esta sección --}}

<!DOCTYPE html>
<html>
<head>
    <title>Periodo Academico</title>
</head>
<body>
    <table border="1">
        <thead>
            <tr>
                <th>Id</th>
                <th>Descripcion</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($periodoacademico as $periodoacademicos)
                <tr>
                    <td>{{ $periodoacademicos->idperoacademico }}</td>
                    <td>{{ $periodoacademicos->descripcion }}</td>
                    <td>{{ $periodoacademicos->estado }}</td>
                
                    <td>
                        
                        <a href="{{ route('periodoacademico.edit', $periodoacademicos->idperoacademico) }}" class="btn btn-primary">Editar</a>
                        <form action="{{ route('periodoacademico.destroy', $periodoacademicos->idperoacademico) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
</body>
</html>
@stop