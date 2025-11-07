<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devolver Préstamo #{{ $prestamo->idprestamo }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f7fafc; }
        .card { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); }
    </style>
</head>
<body>
    <div class="container mx-auto p-4 md:p-8 max-w-5xl">
        <div class="card bg-white p-6 rounded-xl">
            <h1 class="text-3xl font-bold text-gray-800 mb-4 border-b pb-2">
                Registro de Devolución para Préstamo #{{ $prestamo->idprestamo }}
            </h1>
            <p class="text-gray-600 mb-6">
                **Docente:** {{ $prestamo->docente->nomcompleto }} | 
                **Fecha de Préstamo:** {{ $prestamo->fechaprestamo }} |
                **Devolución Esperada:** {{ $prestamo->fechadevolucion }}
            </p>

            <!-- Manejo de errores de validación generales -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">¡Error de validación!</strong>
                    <ul class="mt-1 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulario de Devolución -->
            <form method="POST" action="{{ route('prestamos.procesarDevolucion', $prestamo->idprestamo) }}" class="space-y-6">
                @csrf
                
                <h2 class="text-xl font-semibold text-gray-700">Equipos Pendientes de Devolución</h2>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Devolver</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Equipo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Observación Entrega</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Real de Devolución</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Observación Devolución</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado Final</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($detalles as $detalle)
                                <tr class="hover:bg-yellow-50/50">
                                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <!-- Checkbox para indicar si se está devolviendo -->
                                        <input type="checkbox" name="devoluciones[{{ $detalle->id_detalleprestamo }}][devolver]" 
                                               id="devolver_{{ $detalle->id_detalleprestamo }}"
                                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    </td>
                                    <td class="px-6 py-4 whitespace-pre-nowrap text-sm text-gray-500 max-w-xs">
                                        {{ $detalle->equipo->descripcion }} <!-- Asume que el modelo Equipo tiene un campo 'nombre_o_codigo' -->
                                    </td>
                                    <td class="px-6 py-4 whitespace-pre-nowrap text-sm text-gray-500 max-w-xs">
                                        {{ $detalle->observacionentrega ?? 'N/A' }}
                                    </td>

                                    <!-- Campo de Fecha Real de Devolución -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <input type="date" name="devoluciones[{{ $detalle->id_detalleprestamo }}][fecha_devolucion_real]" 
                                               value="{{ date('Y-m-d') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    </td>

                                    <!-- Campo de Observación de Devolución -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <textarea name="devoluciones[{{ $detalle->id_detalleprestamo }}][observaciondevolucion]" 
                                                  placeholder="Estado al devolver"
                                                  rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                                    </td>

                                    <!-- Campo de Estado Final -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <select name="devoluciones[{{ $detalle->id_detalleprestamo }}][estado_detalle]" 
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            <option value="">Seleccionar Estado</option>
                                            <option value="Devuelto">Devuelto (OK)</option>
                                            <option value="Dañado">Dañado</option>
                                            <option value="Perdido">Perdido</option>
                                        </select>
                                        <!-- NOTA: 'Vencido' y 'Cancelado' no deben ser seleccionables aquí por el usuario. -->
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No hay equipos pendientes de devolución en este préstamo.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-end pt-4 border-t">
                    <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                        Procesar Devoluciones Seleccionadas
                    </button>
                    <a href="{{ route('prestamos.index') }}" class="ml-4 inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition duration-150 ease-in-out">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
