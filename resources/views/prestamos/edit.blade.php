@extends('adminlte::page')

@section('title', 'Editar Préstamo')

@section('content_header')
    <h1>Editar Préstamo</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Editar Préstamo #{{ $prestamo->idprestamo }}</h3>
        </div>
        <!-- /.card-header -->
        <!-- Formulario -->
        <form id="editLoanForm" action="{{ route('prestamos.update', $prestamo->idprestamo) }}" method="POST">
            @csrf
            @method('PUT') {{-- Importante para indicar que es una petición PUT/PATCH --}}

            <div class="card-body">
                {{-- Mensajes de error globales o de sesión --}}
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Campos del Préstamo Principal --}}
                <div class="form-group">
                    <label for="docente">Nombre del Docente:</label>
                    <select name="iddocente" id="docente" class="form-control @error('iddocente') is-invalid @enderror">
                        <option value="">Seleccione un docente</option>
                        @foreach($docentes as $docente)
                            <option value="{{ $docente->iddocente }}" {{ old('iddocente', $prestamo->iddocente) == $docente->iddocente ? 'selected' : '' }}>
                                {{ $docente->numdocumento }} - {{ $docente->nomcompleto }}
                            </option>
                        @endforeach
                    </select>
                    @error('iddocente')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="ubicacione">Nombre de la ubicación:</label>
                    <select name="idubicacion" id="ubicacione" class="form-control @error('idubicacion') is-invalid @enderror">
                        <option value="">Seleccione una ubicación</option>
                        @foreach($ubicaciones as $ubicacione)
                            <option value="{{ $ubicacione->idubicacion }}" {{ old('idubicacion', $prestamo->idubicacion) == $ubicacione->idubicacion ? 'selected' : '' }}>
                                {{ $ubicacione->codsalon }} - {{ $ubicacione->codsalon }}
                            </option>
                        @endforeach
                    </select>
                    @error('idubicacion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="fechaprestamo">Fecha de préstamo:</label>
                    <input type="date" class="form-control @error('fechaprestamo') is-invalid @enderror" name="fechaprestamo" id="fechaprestamo" value="{{ old('fechaprestamo', $prestamo->fechaprestamo ? \Carbon\Carbon::parse($prestamo->fechaprestamo)->format('Y-m-d') : '') }}" required>
                    @error('fechaprestamo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                {{-- <div class="form-group">
                    <label for="usuario">Usuario:</label>
                    <select name="idusuario" id="usuario" class="form-control @error('idusuario') is-invalid @enderror">
                        <option value="">Seleccione un usuario</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->idusuario }}" {{ old('idusuario', $prestamo->idusuario) == $usuario->idusuario ? 'selected' : '' }}>
                                {{ $usuario->nomusuario }} - {{ $usuario->nomcompleto }}
                            </option>
                        @endforeach
                    </select>
                    @error('idusuario')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div> --}}

                <div class="form-group">
                    <label for="periodoacademi">Periodo académico:</label>
                    <select name="idperoacademico" id="periodoacademi" class="form-control @error('idperoacademico') is-invalid @enderror">
                        <option value="">Seleccione un periodo académico</option>
                        @foreach($periodoacademico as $periodoacademi)
                            <option value="{{ $periodoacademi->idperoacademico }}" {{ old('idperoacademico', $prestamo->idperoacademico) == $periodoacademi->idperoacademico ? 'selected' : '' }}>
                                {{ $periodoacademi->descripcion }}
                            </option>
                        @endforeach
                    </select>
                    @error('idperoacademico')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="estado">Estado del Préstamo:</label>
                    <select name="estado" id="estado" class="form-control @error('estado') is-invalid @enderror" required>
                        <option value="Activo" {{ old('estado', $prestamo->estado) == 'Activo' ? 'selected' : '' }}>Activo</option>
                        <option value="Vencido" {{ old('estado', $prestamo->estado) == 'Vencido' ? 'selected' : '' }}>Vencido</option>
                        <option value="Cancelado" {{ old('estado', $prestamo->estado) == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                        <option value="Finalizado" {{ old('estado', $prestamo->estado) == 'Finalizado' ? 'selected' : '' }}>Finalizado</option>
                    </select>
                    @error('estado')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr>
                <h4>Detalles de Equipos del Préstamo</h4>
                @error('equipos')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <div id="equipos-container">
                    {{-- Renderizar los equipos existentes o los viejos datos si hubo un error de validación --}}
                    @php
                        $detallesFromModel = $prestamo->detalles ?? collect(); 
                        $currentEquipos = old('equipos', $detallesFromModel->toArray());
                        
                    @endphp

                    @forelse ($currentEquipos as $index => $equipoDetalle)
                        @include('prestamos._equipo_detalle_row', [
                            'index' => $index,
                            'equipos' => $equipos,
                            'equipoDetalle' => $equipoDetalle,
                            'isEdit' => true // Indica que estamos en modo edición
                        ])
                    @empty
                        {{-- Si no hay equipos existentes ni old data, añadir una fila inicial vacía --}}
                        @include('prestamos._equipo_detalle_row', [
                            'index' => 0,
                            'equipos' => $equipos,
                            'isEdit' => true // Indica que estamos en modo edición
                        ])
                    @endforelse
                </div>

                <button type="button" id="add-equipment-btn" class="btn btn-success mt-3 mb-4">
                    <i class="fas fa-plus"></i> Añadir Equipo
                </button>

            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    Actualizar Préstamo
                </button>
                <a href="{{ route('prestamos.index') }}" class="btn btn-secondary ml-2">Regresar</a>
            </div>
        </form>
    </div>
    <!-- /.card -->
@stop

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // --- Lógica para añadir/eliminar filas de equipo dinámicamente ---
            // Inicializa el índice basado en el número de equipos existentes o viejos datos
            let equipmentIndex = {{ old('equipos') ? count(old('equipos')) : ($prestamo->detalles ? count($prestamo->detalles) : 0) }};
            

            const equiposContainer = document.getElementById('equipos-container');
            const addEquipmentBtn = document.getElementById('add-equipment-btn');

            // Función para añadir una nueva fila de equipo
            function addEquipmentRow() {
                const template = `
                    <div class="card card-secondary equipment-row mt-3" data-index="${equipmentIndex}">
                        <div class="card-header">
                            <h3 class="card-title">Equipo #${equipmentIndex + 1}</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool remove-equipment-row">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            {{-- Campo oculto para el ID del detalle, será nulo para nuevos --}}
                            <input type="hidden" name="equipos[${equipmentIndex}][iddetprestamo]" value="">

                            <div class="form-group">
                                <label for="idequipo_${equipmentIndex}">Seleccionar Equipo:</label>
                                <select name="equipos[${equipmentIndex}][idequipo]" id="idequipo_${equipmentIndex}" class="form-control" required>
                                    <option value="">Seleccione un equipo</option>
                                    {{-- La lista de equipos se inserta aquí en el lado del servidor --}}
                                    @foreach($equipos as $equipo)
                                        <option value="{{ $equipo->idequipo }}">{{ $equipo->codequipo }} - {{ $equipo->descripcion }} - {{ $equipo->numserial }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="fechaentrega_${equipmentIndex}">Fecha de Entrega:</label>
                                <input type="date" name="equipos[${equipmentIndex}][fechaentrega]" id="fechaentrega_${equipmentIndex}" class="form-control" required>
                            </div>
                    
                            <div class="form-group">
                                <label for="observacionentrega_${equipmentIndex}">Observación de Entrega:</label>
                                <input type="text" name="equipos[${equipmentIndex}][observacionentrega]" id="observacionentrega_${equipmentIndex}" class="form-control" maxlength="100" required>
                            </div>
                            <div class="form-group">
                                <label for="observaciondevolucion_${equipmentIndex}">Observación de Devolución:</label>
                                <input type="text" name="equipos[${equipmentIndex}][observaciondevolucion]" id="observaciondevolucion_${equipmentIndex}" class="form-control" maxlength="100" required>
                            </div>
                            <div class="form-group">
                                <label for="estado_detalle_${equipmentIndex}">Estado del Detalle:</label>
                                <select name="equipos[${equipmentIndex}][estado_detalle]" id="estado_detalle_${equipmentIndex}" class="form-control" required>
                                    <option value="entregado">Entregado</option>
                                    <option value="devuelto">Devuelto</option>
                                    <option value="vencido">Vencido</option>
                                    <option value="dañado">Dañado</option>
                                </select>
                            </div>
                        </div>
                    </div>
                `;
                const newRowElement = document.createElement('div');
                newRowElement.innerHTML = template.trim();
                equiposContainer.appendChild(newRowElement.firstChild);
                equipmentIndex++;

                // Adjuntar listener al nuevo botón de eliminar
                newRowElement.querySelector('.remove-equipment-row').addEventListener('click', function() {
                    this.closest('.equipment-row').remove();
                });
            }

            // Event listener para el botón "Añadir Equipo"
            if (addEquipmentBtn) {
                addEquipmentBtn.addEventListener('click', addEquipmentRow);
            }

            // Adjuntar listeners para eliminar a las filas existentes (si hay)
            document.querySelectorAll('.remove-equipment-row').forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('.equipment-row').remove();
                });
            });
        });
    </script>
@stop