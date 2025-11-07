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

            /* Reducir tamaño de iconos y texto de la paginación */
        .pagination {
            font-size: 0.85rem; /* Reduce texto e íconos */
        }

        .pagination .page-link {
            padding: 4px 8px;
            font-size: 0.85rem;
        }

        .pagination svg {
            width: 12px;
            height: 12px;
        }
    </style>
</head>
<body>

     {{-- FILTRO POR ESTADO --}}
    <form method="GET" action="{{ route('prestamos.index') }}" class="mb-3">
        <div class="form-group d-flex align-items-center gap-2">
            <label for="estado">Filtrar por estado:</label>
            <select name="estado" id="estado" class="form-control w-auto">
                <option value="">-- Todos --</option>
                <option value="Cancelado" {{ request('estado') == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                <option value="Activo" {{ request('estado') == 'Activo' ? 'selected' : '' }}>Activo</option>
                <option value="Vencido" {{ request('estado') == 'Vencido' ? 'selected' : '' }}>Vencido</option>
                <option value="Finalizado" {{ request('estado') == 'Finalizado' ? 'selected' : '' }}>Finalizado</option>
            </select>
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fas fa-filter"></i> Filtrar
            </button>
            <a href="{{ route('prestamos.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-undo"></i> Limpiar
            </a>
        </div>
    </form>
   
    <table border="1">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre del Docente ID</th>
                <th>Ubicacion ID</th>
                <th>Fecha de prestamo</th>
                <th>Periodo academico ID</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($prestamos as $prestamo)
                <tr>
                    <td>{{ $prestamo->idprestamo }}</td>
                    <td>{{ $prestamo->nomfuncionarios }}</td>
                    <td>{{ $prestamo->ubicacion->codsalon }}</td>
                    <td>{{ $prestamo->fechaprestamo }}</td>
                    <td>{{ ($prestamo->periodoacademico)->descripcion }}</td>
                    
                    {{-- <td>
                        @if ($prestamo->periodoacademico)
                            {{ $prestamo->periodoacademico->idperoacademico }}
                        @else
                            Sin periodo <span class="badge bg-success">Activo</span>
                        @endif
                    </td> --}}
                    <td class="table-info"><strong>{{ $prestamo->estado }}</strong>
                    @if($prestamo->estado === $prestamo::ESTADO_ACTIVO || $prestamo->estado === $prestamo::ESTADO_VENCIDO)
                        <span class="text-sm font-semibold text-gray-600">
                        {{ $prestamo->progreso_devolucion }}
                    </span>
                        
                    @endif
                    </td>
                    {{-- <span class="badge text-bg-success">Success</span> --}}
                    <td>
                        <a href="{{ route('prestamos.show', $prestamo->idprestamo) }}" title="Ver Detalles" style="font-size: 1rem;">
                            <i class="fas fa-eye"></i>
                        </a>
                        {{-- <a href="{{ route('prestamos.edit', $prestamo->idprestamo) }}" class="btn btn-primary">Editar</a> --}}
                        <form action="{{ route('prestamos.destroy', $prestamo->idprestamo) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            {{-- <button type="submit" class="btn btn-danger">Eliminar</button> --}}
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

     {{-- PAGINACIÓN --}}
    <div class="d-flex justify-content-center pagination page-link ">
        {{ $prestamos->appends(request()->query())->links() }}
    </div>
</body>
</html>
@stop


