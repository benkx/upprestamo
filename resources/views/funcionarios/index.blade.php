<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Funcionarios (Oracle)</title>
    <!-- Incluye Tailwind CSS (o tu framework de estilos preferido) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Estilos base para la tabla */
        .table-auto { 
            border-collapse: collapse; 
        }
        .table-auto th, .table-auto td { 
            padding: 12px 15px; 
            border-bottom: 1px solid #e5e7eb; 
        }
        .table-auto th { 
            text-align: left; 
            background-color: #f3f4f6; 
            color: #1f2937; 
            font-weight: 600; 
            text-transform: uppercase;
        }
    </style>
</head>
<body class="bg-gray-100 p-8">

    <div class="max-w-7xl mx-auto bg-white shadow-xl rounded-lg p-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 border-b pb-3">
            Listado de Funcionarios
            <span class="text-base font-normal text-gray-500 block">Datos obtenidos de la vista Oracle: V_funcionarios</span>
        </h1>

        {{-- Mostrar Errores de Conexión si existen --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Error de Conexión:</strong>
                <span class="block sm:inline">{{ $errors->first('oracle') }}</span>
            </div>
        @endif

        {{-- Mostrar la tabla de datos --}}
        @if (isset($funcionarios) && count($funcionarios) > 0)
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr>
                            {{--
                                NOTA IMPORTANTE: Los nombres de las columnas (claves del objeto)
                                son dinámicos y dependen de la vista de Oracle.
                                Se recomienda revisar las claves del primer objeto para ajustar los títulos TH.
                                Aquí se asumen nombres genéricos de ejemplo.
                            --}}
                            @php
                                // Intentar obtener las claves del primer objeto si existe
                                $keys = array_keys((array)$funcionarios[0]);
                            @endphp
                            
                            {{-- Generación dinámica de encabezados --}}
                            @foreach ($keys as $key)
                                <th>{{ str_replace('_', ' ', strtoupper($key)) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($funcionarios as $funcionario)
                            <tr class="hover:bg-gray-50">
                                {{-- Generación dinámica de celdas --}}
                                @foreach ($keys as $key)
                                    <td>{{ $funcionario->$key ?? 'N/A' }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @elseif (isset($funcionarios) && count($funcionarios) === 0)
            <div class="text-center py-10 text-gray-500 border border-dashed border-gray-300 rounded-lg">
                <p>No se encontraron funcionarios en la vista de Oracle.</p>
            </div>
        @else
            {{-- Esto se mostrará si hay un error de conexión que oculta la tabla --}}
            <div class="text-center py-10 text-gray-500 border border-dashed border-gray-300 rounded-lg">
                <p>Cargando datos. Asegúrese de que la conexión a Oracle esté configurada y sea accesible.</p>
            </div>
        @endif
    </div>

</body>
</html>
