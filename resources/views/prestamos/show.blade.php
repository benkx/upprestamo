<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Préstamo #{{ $prestamo->idprestamo }}</title>
    <!-- Asumiendo el uso de Tailwind CSS o estilos básicos -->
    <style>
        .container { max-width: 900px; margin: 0 auto; padding: 20px; }
        .card { background: #fff; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); padding: 20px; margin-bottom: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #eee; padding-bottom: 10px; margin-bottom: 15px; }
        .status-badge { 
            padding: 5px 10px; 
            border-radius: 9999px; 
            font-size: 0.875rem; 
            font-weight: 600;
        }
        /* Colores de estado simplificados */
        .status-Activo { background-color: #fcd34d; color: #78350f; }
        .status-Finalizado { background-color: #34d399; color: #065f46; }
        .status-Vencido { background-color: #f87171; color: #991b1b; }
        .status-Dañado { background-color: #bfdbfe; color: #1e40af; }
        .status-Entregado { background-color: #d1d5db; color: #374151; }

        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #e5e7eb; }
        th { background-color: #f3f4f6; color: #1f2937; }
        .detail-row:hover { background-color: #f9fafb; }
    </style>
</head>
<body style="background-color: #f3f4f6; font-family: sans-serif;">
    <div class="container">
        
        <div class="header">
            <h1 style="font-size: 1.5rem; font-weight: 700; color: #1f2937;">
                Detalle del Préstamo #{{ $prestamo->idprestamo }}
            </h1>
            <a href="{{ route('prestamos.index') }}" style="color: #4f46e5; text-decoration: none;">&larr; Volver al Listado</a>
        </div>
        
        <!-- Tarjeta de Resumen Principal -->
        <div class="card">
            <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 15px; color: #374151;">Información General</h2>
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; font-size: 1rem;">
                
                <!-- Columna 1 -->
                <div>
                    <p style="margin-bottom: 8px;"><strong style="color: #4b5563;">Docente:</strong> {{ $prestamo->nomfuncionarios ?? 'N/A' }}</p>
                    <p style="margin-bottom: 8px;"><strong style="color: #4b5563;">Ubicación:</strong> {{ $prestamo->ubicacion->codsalon ?? 'N/A' }}</p>
                    <p style="margin-bottom: 8px;"><strong style="color: #4b5563;">Período Académico:</strong> {{ $prestamo->periodoacademico->descripcion ?? 'N/A' }}</p>
                </div>

                <!-- Columna 2 -->
                <div>
                    <p style="margin-bottom: 8px;"><strong style="color: #4b5563;">Fecha de Préstamo:</strong> {{ $prestamo->fechaprestamo->format('d/m/Y') }}</p>
                    <p style="margin-bottom: 8px;"><strong style="color: #4b5563;">Fecha de Devolución (Esperada):</strong> {{ $prestamo->fechadevolucion ? $prestamo->fechadevolucion->format('d/m/Y') : 'No Especificada' }}</p>
                    <p style="margin-bottom: 8px;"><strong style="color: #4b5563;">Creado por:</strong> {{ $prestamo->usuario->nomusuario ?? 'Sistema' }}</p>
                </div>
            </div>
            
            <div style="margin-top: 15px; padding-top: 15px; border-top: 1px dashed #e5e7eb; display: flex; gap: 30px; align-items: center;">
                <p>
                    <strong style="color: #4b5563;">Estado Principal:</strong> 
                    <span class="status-badge status-{{ str_replace('/', '', $prestamo->estado) }}">
                        {{ $prestamo->estado }}
                    </span>
                </p>
                
                {{-- Muestra el progreso de devolución usando el Accessor --}}
                @if ($prestamo->progreso_devolucion)
                    <p style="font-size: 1rem; color: #1f2937;">
                        <strong style="color: #4b5563;">Equipos Devueltos:</strong> 
                        <span style="font-weight: 700;">{{ $prestamo->progreso_devolucion }}</span>
                    </p>
                @endif
            </div>

        </div>

        <!-- Tarjeta de Detalles del Equipo -->
        <div class="card">
            <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 15px; color: #374151;">Equipos Prestados</h2>
            
            <table>
                <thead>
                    <tr>
                        <th>ID Detalle</th>
                        <th>Equipo</th>
                        <th>N° de Serie</th>
                        <th>Estado Actual</th>
                        <th>Observación de Devolución</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($prestamo->detalles as $detalle)
                        <tr class="detail-row">
                            <td>{{ $detalle->iddetprestamo }}</td>
                            <td>{{ $detalle->equipo->descripcion ?? 'Equipo no encontrado' }}</td>
                            <td>{{ $detalle->equipo->numserial ?? 'N/A' }}</td>
                            <td>
                                <span class="status-badge status-{{ $detalle->estado_detalle }}">
                                    {{ $detalle->estado_detalle }}
                                </span>
                            </td>
                            <td>
                                {{ $detalle->observaciondevolucion ?? 'Sin observaciones' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: #6b7280;">No hay equipos asociados a este préstamo.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</body>
</html>