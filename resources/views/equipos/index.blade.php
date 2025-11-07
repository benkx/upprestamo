@extends('adminlte::page')
@section('title', 'Equipos')


@section('content_header') {{-- Sección específica de AdminLTE para el encabezado --}}
    <h1>Equipos
        <a href="{{ route('equipos.create') }}" class="btn btn-success btn-sm">
            <i class="fas fa-plus-circle"></i> Nuevo
        </a>
    </h1>
@stop


@section('content') {{-- Contenido principal debe usar esta sección --}}
<!DOCTYPE html>
<html>
<head>
    <title>Equipos</title>
        <style>
        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ccc;
        }
        th, td {
            border-top: 1px solid #ccc;
            border-bottom: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            background-color: white;
        }
        th {
            border-top: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>


    <table border="1">
        <thead>
            <tr>
                <th>Id</th>
                <th>Descripcion</th>
                <th>Codigo del Equipo</th>
                <th>Numero serial</th>
                <th>Tipo de Equipo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($equipos as $equipo)
                <tr>
                    <td>{{ $equipo->idequipo }}</td>
                    <td>{{ $equipo->descripcion }}</td>
                    <td>{{ $equipo->codequipo }}</td>
                    <td>{{ $equipo->numserial }}</td>
                    <td>{{ $equipo->tipoequipo }}</td>
                    <td>{{ $equipo->estado }}</td>
                    <td>
                        
                        <a href="{{ route('equipos.edit', $equipo->idequipo) }}" class="btn btn-primary">Editar</a>
                        <form action="{{ route('equipos.destroy', $equipo->idequipo) }}" method="POST" style="display:inline;">
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