<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario de Recursos Físicos (Oracle)</title>
    <!-- Incluye Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Estilos base para la tabla, adaptados de la plantilla original */
        .table-auto { 
            border-collapse: collapse; 
        }
        .table-auto th, .table-auto td { 
            padding: 12px 15px; 
            border-bottom: 1px solid #e5e7eb; 
            vertical-align: top;
        }
        .table-auto th { 
            text-align: left; 
            background-color: #eef2ff; /* Color de encabezado */
            color: #4338ca; /* Indigo oscuro */
            font-weight: 700; 
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
    </style>
</head>
<body class="bg-gray-50 p-4 sm:p-8">

    <div class="max-w-7xl mx-auto bg-white shadow-2xl rounded-xl p-6 sm:p-10">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-2">
            Inventario de Recursos Físicos
        </h1>
        <p class="text-base font-medium text-indigo-600 mb-6 border-b pb-4">
            Datos obtenidos de la vista Oracle: V_RECURSOS_FISICOS
        </p>

        {{-- Mostrar Errores de Conexión si existen --}}
        @if (isset($errors) && $errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6" role="alert">
                <p class="font-bold">Error de Conexión:</p>
                <p>{{ $errors->first('oracle') ?? 'No se pudo conectar a la fuente de datos de Oracle.' }}</p>
            </div>
        @endif

        {{-- Mostrar la tabla de datos --}}
        @if (isset($recursos) && count($recursos) > 0)
            <p class="text-sm text-gray-600 mb-4">
                Total de recursos encontrados: <strong class="text-gray-900">{{ count($recursos) }}</strong>
            </p>

            <div class="overflow-x-auto shadow-md rounded-lg">
                <table class="w-full table-auto text-sm text-gray-700">
                    <thead>
                        <tr>
                            @php
                                // Obtener las claves del primer objeto de recurso para generar los encabezados
                                // Esto asegura que se muestren exactamente los campos: SEDE, UBICACION, TIPORECURSO, RECURSOFISICO, o cualquier otro campo retornado.
                                $keys = array_keys((array)$recursos[0]);
                            @endphp
                            
                            {{-- Generación dinámica de encabezados --}}
                            @foreach ($keys as $key)
                                <th>{{ str_replace('_', ' ', strtoupper($key)) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recursos as $recurso)
                            <tr class="hover:bg-indigo-50 transition duration-150">
                                {{-- Generación dinámica de celdas --}}
                                @foreach ($keys as $key)
                                    <td>
                                        {{-- Lógica especial para colorear el ESTADO si la clave existe --}}
                                        @if (strtoupper($key) === 'ESTADO' || strtoupper($key) === 'ESTADORECURSO')
                                            @php
                                                $estado = strtoupper($recurso->$key ?? 'DESCONOCIDO');
                                                $clase = 'bg-gray-200 text-gray-700';
                                                if (in_array($estado, ['OPERATIVO', 'BUENO', 'ACTIVO'])) {
                                                    $clase = 'bg-green-100 text-green-700';
                                                } elseif (in_array($estado, ['MANTENIMIENTO', 'REPARACION'])) {
                                                    $clase = 'bg-yellow-100 text-yellow-700';
                                                } elseif (in_array($estado, ['INACTIVO', 'DADO DE BAJA', 'MALO'])) {
                                                    $clase = 'bg-red-100 text-red-700';
                                                }
                                            @endphp
                                            <span class="inline-block px-3 py-1 font-semibold text-xs leading-tight rounded-full {{ $clase }}">
                                                {{ $estado }}
                                            </span>
                                        @else
                                            {{ $recurso->$key ?? 'N/A' }}
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @elseif (isset($recursos) && count($recursos) === 0)
            <div class="text-center py-12 text-gray-500 border border-dashed border-indigo-300 bg-indigo-50 rounded-lg">
                <p class="text-lg font-medium">No se encontraron recursos físicos en la vista de Oracle.</p>
            </div>
        @else
            <div class="text-center py-12 text-gray-500 border border-dashed border-gray-300 rounded-lg">
                <p>Asegúrese de que la conexión a Oracle esté configurada y la variable `$recursos` contenga datos.</p>
            </div>
        @endif
    </div>

</body>
</html>