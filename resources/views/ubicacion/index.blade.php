@extends('adminlte::page') {{-- Cambiar a layout de AdminLTE --}}

@section('title', 'Ubicación') {{-- Título para pestaña del navegador --}}

@section('content_header') {{-- Sección específica de AdminLTE para el encabezado --}}
    <h1>Ubicación
        <a href="{{ route('ubicacion.create') }}" class="btn btn-success btn-sm">
            <i class="fas fa-plus-circle"></i> Nuevo
        </a>
    </h1>
@stop

@section('content') {{-- Contenido principal debe usar esta sección --}}
<!DOCTYPE html>
<html>
<head>
    <title>Ubicación</title>
</head>
<body>
    
    <table border="1">
        <thead>
            <tr>
                <th>Id</th>
                <th>Codigo del Salon</th>
                <th>Dotación</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ubicacion as $ubicacione)
                <tr>
                    <td>{{ $ubicacione->idubicacion }}</td>
                    <td>{{ $ubicacione->codsalon }}</td>
                    <td>{{ $ubicacione->dotacion }}</td>
                    <td>{{ $ubicacione->estado }}</td>
                    <td>
                        {{-- <a href="{{ route('ubicacion.show', $ubicacione->idubicacion) }}">Ver</a> --}}
                        <a href="{{ route('ubicacion.edit', $ubicacione->idubicacion) }}"class="btn btn-primary">Editar</a>
                        <form action="{{ route('ubicacion.destroy', $ubicacione->idubicacion) }}" method="POST" style="display:inline;">
                            {{-- Método POST para eliminar --}}
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