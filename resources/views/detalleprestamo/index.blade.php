
@extends('adminlte::page') {{-- Cambiar a layout de AdminLTE --}}

@section('title', 'Detalle Prestamo') {{-- Título para pestaña del navegador --}}

@section('content_header') {{-- Sección específica de AdminLTE para el encabezado --}}
    <h1>Detalle prestamo
        <a href="{{ route('detalleprestamo.create') }}" class="btn btn-success btn-sm">
            <i class="fas fa-plus-circle"></i> Nuevo
        </a>
    </h1>
@stop


<body>
    @section('content') {{-- Contenido principal debe usar esta sección --}}
    <table border="1">
        <thead>
            <tr>
                <th>Id</th>
                <th>Prestamo ID</th>
                <th>Equipo ID</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($detalleprestamo as $detalleprestamos)
                <tr>
                    <td>{{ $detalleprestamos->iddetprestamo }}</td>
                    <td>{{ $detalleprestamos->idprestamo }}</td>
                    <td>{{ $detalleprestamos->idequipo }}</td>
                
                    <td>
                        {{-- <a href="{{ route('detalleprestamo.show', $detalleprestamos->iddetprestamo) }}">Ver</a> --}}
                        <a href="{{ route('detalleprestamo.edit', $detalleprestamos->iddetprestamo) }}">Editar</a>
                        <form action="{{ route('detalleprestamo.destroy', $detalleprestamos->iddetprestamo) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
</body>
</html>
@stop