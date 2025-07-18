@extends('adminlte::page') {{-- Cambiar a layout de AdminLTE --}}

@section('title', 'Solicitud de Mantenimiento') {{-- Título para pestaña del navegador --}}

@section('content_header') {{-- Sección específica de AdminLTE para el encabezado --}}
    <h1>Solicitud de Mantenimiento
        <a href="{{ route('solimantenimiento.create') }}" class="btn btn-success btn-sm">
            <i class="fas fa-plus-circle"></i> Nuevo
        </a>
    </h1>
@stop

<!DOCTYPE html>
<html>
<head>
    <title>Mantenimiento</title>
</head>
<body>
@section('content') {{-- Contenido principal debe usar esta sección --}}
    <table border="1">
        <thead>
            <tr>
                <th>Id</th>
                <th>Fecha de Solicitud</th>
                <th>Equipos</th>
                <th>Descripción</th>
                <th>Fecha de Cierre</th>
                <th>Usuario</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($solimantenimiento as $solimantes)
                <tr>
                    <td>{{ $solimantes->idsolicitud }}</td>
                    <td>{{ $solimantes->fechasolicitud }}</td>
                    <td>{{ $solimantes->idequipo }}</td>
                    <td>{{ $solimantes->descripcion }}</td>
                    <td>{{ $solimantes->fechacierre }}</td>
                    <td>{{ $solimantes->idusuario }}</td>
                    <td>{{ $solimantes->estado }}</td>
                    <td>
                        <a href="{{ route('solimantenimiento.edit', $solimantes->idsolicitud) }}" class="btn btn-primary">Editar</a>
                        <form action="{{ route('solimantenimiento.destroy', $solimantes->idsolicitud) }}" method="POST" style="display:inline;">
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