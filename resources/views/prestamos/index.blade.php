@extends('adminlte::page') {{-- Cambiar a layout de AdminLTE --}}

@section('title', 'Prestamo de Equipos') {{-- Título para pestaña del navegador --}}

@section('content_header') {{-- Sección específica de AdminLTE para el encabezado --}}
    <h1>Prestamo
        <a href="{{ route('prestamos.create') }}" class="btn btn-success btn-sm">
            <i class="fas fa-plus-circle"></i> Nuevo
        </a>
    </h1>
@stop

@section('content') {{-- Contenido principal debe usar esta sección --}}
<!DOCTYPE html>
<html>
<head>
    <title>Prestamo</title>
</head>
<body>
   
    <table border="1">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre del Docente ID</th>
                <th>Ubicacion ID</th>
                <th>Fecha de prestamo</th>
                <th>Nombre de usuario ID</th>
                <th>Periodo academico ID</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($prestamos as $prestamo)
                <tr>
                    <td>{{ $prestamo->idprestamo }}</td>
                    <td>{{ ($prestamo->docente)->nomcompleto }}</td>
                    <td>{{ $prestamo->ubicacion->codsalon }}</td>
                    <td>{{ $prestamo->fechaprestamo }}</td>
                    <td>{{ $prestamo->usuario->nomusuario }}</td>
                    <td>{{ ($prestamo->periodoacademico)->descripcion }}</td>
                    
                    {{-- <td>
                        @if ($prestamo->periodoacademico)
                            {{ $prestamo->periodoacademico->idperoacademico }}
                        @else
                            Sin periodo
                        @endif
                    </td> --}}
                    <td class="table-success"><strong>{{ $prestamo->estado }}</strong></td>
                    <td>
                        <a href="{{ route('prestamos.show', $prestamo->idprestamo) }}" class="btn btn-info">Ver</a>
                        <a href="{{ route('prestamos.edit', $prestamo->idprestamo) }}" class="btn btn-primary">Editar</a>
                        <form action="{{ route('prestamos.destroy', $prestamo->idprestamo) }}" method="POST" style="display:inline;">
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