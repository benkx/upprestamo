@extends('adminlte::page') {{-- Cambiar a layout de AdminLTE --}}

@section('title', 'Devoluciones de Equipos') {{-- Título para pestaña del navegador --}}

@section('content_header') {{-- Sección específica de AdminLTE para el encabezado --}}


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Devoluciones Pendientes</title>
    <!-- Carga de Tailwind CSS (Ajusta la URL si usas una instalación local) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7f9; }
        .sticky-header { top: 0; z-index: 10; }
        .table-container { max-height: 70vh; overflow-y: auto; }
        /* Estilo para los inputs de la tabla */
        .table-input { border: 1px solid #d1d5db; padding: 4px 8px; border-radius: 6px; width: 100%; font-size: 0.875rem; }
    </style>
</head>
@section('content') {{-- Contenido principal debe usar esta sección --}}
<body class="p-4 md:p-8">
    <div class="max-w-7xl mx-auto bg-white shadow-xl rounded-lg overflow-hidden">
        <header class="bg-indigo-600 p-6 text-white sticky-header rounded-t-lg">
            <h1 class="text-3xl font-bold">🛠️ Gestión de Devoluciones Pendientes</h1>
            <p class="mt-1 text-indigo-200">Seleccione los equipos que han sido devueltos y su estado final.</p>
        </header>

        <!-- Mensajes de Sesión -->
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <form action="{{ route('devoluciones.procesar') }}" method="POST">
            @csrf

            @if ($equiposPendientes->isEmpty())
                <div class="p-6 text-center text-gray-500">
                    <p class="text-xl mt-4">🎉 ¡No hay equipos pendientes de devolución!</p>
                    <p class="mt-2">Todos los préstamos activos están al día.</p>
                </div>
            @else
                <div class="p-4 bg-gray-50 border-b flex justify-between items-center">
                     <a href="{{ route('prestamos.index') }}" style="color: #4f46e5; text-decoration: none;">&larr; Volver al Listado</a>
                    <p class="text-sm text-gray-600 font-medium">Equipos a devolver: **{{ $equiposPendientes->count() }}**</p>
                    <button type="submit" 
                            class="px-6 py-2 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 transition duration-150 shadow-md">
                        Procesar Devoluciones Seleccionadas
                    </button>
                </div>
                
                <div class="table-container">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 sticky-header">
                            <tr>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-10">
                                    <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Préstamo / Docente</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Equipo (ID)</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Observación de Entrega</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Estado Final</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-56">Observación de Devolución</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($equiposPendientes as $detalle)
                                @php
                                    $index = $detalle->iddetprestamo; // Usamos el ID del detalle como índice para el array
                                    $isVencido = \Carbon\Carbon::parse($detalle->prestamo->fechadevolucion)->isPast();
                                @endphp
                                <tr class="{{ $isVencido ? 'bg-red-50 hover:bg-red-100' : 'hover:bg-gray-50' }}">
                                    <!-- CHECKBOX -->
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        <input type="checkbox" 
                                               name="devoluciones[{{ $index }}][iddetprestamo]" 
                                               value="{{ $detalle->iddetprestamo }}"
                                               class="devolucion-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </td>
                                    
                                    <!-- INFORMACIÓN DEL PRÉSTAMO -->
                                    <td class="px-6 py-3 text-sm text-gray-900">
                                        <span class="font-bold">#{{ $detalle->prestamo->idprestamo }}</span> 
                                        - {{ $detalle->prestamo->nomfuncionarios }}
                                        <div class="text-xs text-gray-500">
                                            <span class="font-semibold">F. Préstamo:</span> {{ \Carbon\Carbon::parse($detalle->prestamo->fechaprestamo)->format('d/m/Y') }}
                                            <span class="font-semibold ml-2 {{ $isVencido ? 'text-red-600' : 'text-orange-600' }}">
                                                F. Límite: {{ \Carbon\Carbon::parse($detalle->prestamo->fechadevolucion)->format('d/m/Y') }}
                                                @if($isVencido) (VENCIDO) @endif
                                            </span>
                                        </div>
                                    </td>

                                    <!-- INFORMACIÓN DEL EQUIPO -->
                                    <td class="px-6 py-3 text-sm text-gray-900">
                                        {{ $detalle->equipo->nombre_equipo }} 
                                        <div class="text-xs text-gray-500">ID: {{ $detalle->equipo->idequipo }}</div>
                                    </td>

                                    <!-- OBSERVACIÓN DE ENTREGA -->
                                    <td class="px-6 py-3 text-sm text-gray-500 max-w-xs overflow-hidden truncate" title="{{ $detalle->observacionentrega }}">
                                        {{ $detalle->observacionentrega ?? 'N/A' }}
                                    </td>

                                    <!-- ESTADO FINAL -->
                                    <td class="px-6 py-3 whitespace-nowrap text-sm">
                                        <select name="devoluciones[{{ $index }}][estado_detalle]" 
                                                class="table-input" >
                                            <option value="" disabled selected>Seleccione</option>
                                            <option value="Devuelto">Devuelto (OK)</option>
                                            <option value="Dañado">Dañado</option>
                                            <option value="Vencido" disabled>Vencido (Automático)</option>
                                        </select>
                                    </td>

                                    <!-- OBSERVACIÓN DE DEVOLUCIÓN -->
                                    <td class="px-6 py-3">
                                        <input type="text" 
                                               name="devoluciones[{{ $index }}][observaciondevolucion]" 
                                               class="table-input" 
                                               placeholder="Condición del equipo al devolver" 
                                               maxlength="255">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-4 bg-gray-50 border-t flex justify-end">
                    <button type="submit" 
                            class="px-6 py-2 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 transition duration-150 shadow-md">
                        Procesar Devoluciones Seleccionadas
                    </button>
                </div>
            @endif
        </form>
    </div>

    <!-- Script para seleccionar/deseleccionar todos los checkboxes -->
    <script>
        document.getElementById('selectAll').addEventListener('change', function(e) {
            const checkboxes = document.querySelectorAll('.devolucion-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = e.target.checked;
            });
        });
    </script>
</body>
</html>
@stop