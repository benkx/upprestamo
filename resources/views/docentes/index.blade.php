@extends('adminlte::page') {{-- Cambiar a layout de AdminLTE --}}

@section('title', 'Docentes') {{-- Título para pestaña del navegador --}}

@section('content_header') {{-- Sección específica de AdminLTE para el encabezado --}}
    <h1>Docentes
        <a href="{{ route('docentes.create') }}" class="btn btn-success btn-sm">
            <i class="fas fa-plus-circle"></i> Nuevo
        </a>
    </h1>
@stop

<!DOCTYPE html>
<html>
<head>
    <title>Docentes</title>
</head>
<body>
    @section('content') {{-- Contenido principal debe usar esta sección --}}
    <table border="1">
        <thead>
            <tr>
                <th>Id</th>
                <th>Numero de documento</th>
                <th>Nombre Completo</th>
                <th>Vinculado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($docentes as $docente)
                <tr>
                    <td>{{ $docente->iddocente }}</td>
                    <td>{{ $docente->numdocumento }}</td>
                    <td>{{ $docente->nomcompleto }}</td>
                    <td>{{ $docente->vinculacion }}</td>
                    <td>
                        {{-- <a href="{{ route('ubicacion.show', $docente->iddocente) }}">Ver</a> --}}
                        <a href="{{ route('docentes.edit', $docente->iddocente) }}" class="btn btn-primary">Editar</a>
                        <form action="{{ route('docentes.destroy', $docente->iddocente) }}" method="POST" style="display:inline;">
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