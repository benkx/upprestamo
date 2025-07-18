@extends('adminlte::page')

@section('title', 'Crear Préstamo')

@section('content_header')
    <h1>Crear Préstamo</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Nuevo Préstamo</h3>
        </div>
        <!-- /.card-header -->
        <!-- Formulario -->
        <form id="createLoanForm" action="{{ route('prestamos.store') }}" method="POST">
            @csrf
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
                            <option value="{{ $docente->iddocente }}" {{ old('iddocente') == $docente->iddocente ? 'selected' : '' }}>
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
                            <option value="{{ $ubicacione->idubicacion }}" {{ old('idubicacion') == $ubicacione->idubicacion ? 'selected' : '' }}>
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
                    <input type="date" class="form-control @error('fechaprestamo') is-invalid @enderror" name="fechaprestamo" id="fechaprestamo" value="{{ old('fechaprestamo') }}" required>
                    @error('fechaprestamo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="fechadevolucion">Fecha de devolución (Préstamo General):</label>
                    <input type="date" class="form-control @error('fechadevolucion') is-invalid @enderror" name="fechadevolucion" id="fechadevolucion" value="{{ old('fechadevolucion') }}">
                    @error('fechadevolucion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="usuario">Usuario:</label>
                    <select name="idusuario" id="usuario" class="form-control @error('idusuario') is-invalid @enderror">
                        <option value="">Seleccione un usuario</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->idusuario }}" {{ old('idusuario') == $usuario->idusuario ? 'selected' : '' }}>
                                {{ $usuario->nomusuario }} - {{ $usuario->nomcompleto }}
                            </option>
                        @endforeach
                    </select>
                    @error('idusuario')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="periodoacademi">Periodo académico:</label>
                    <select name="idperoacademico" id="periodoacademi" class="form-control @error('idperoacademico') is-invalid @enderror">
                        <option value="">Seleccione un periodo académico</option>
                        @foreach($periodoacademico as $periodoacademi)
                            <option value="{{ $periodoacademi->idperoacademico }}" {{ old('idperoacademico') == $periodoacademi->idperoacademico ? 'selected' : '' }}>
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
                    <input type="text" class="form-control @error('estado') is-invalid @enderror" name="estado" id="estado" value="{{ old('estado', 'activo') }}" required>
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
                    {{-- La primera fila de equipo se puede precargar o dejar que JS la añada --}}
                    @if (old('equipos'))
                        @foreach (old('equipos') as $index => $equipoDetalle)
                            @include('prestamos._equipo_detalle_row', ['index' => $index, 'equipos' => $equipos, 'equipoDetalle' => $equipoDetalle])
                        @endforeach
                    @else
                        {{-- Añadir una fila inicial vacía si no hay datos viejos --}}
                        @include('prestamos._equipo_detalle_row', ['index' => 0, 'equipos' => $equipos])
                    @endif
                </div>

                <button type="button" id="add-equipment-btn" class="btn btn-success mt-3 mb-4">
                    <i class="fas fa-plus"></i> Añadir Equipo
                </button>

            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                {{-- Botón "Crear" que envía el formulario directamente --}}
                <button type="submit" class="btn btn-primary">
                    Crear Préstamo
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
            let equipmentIndex = {{ old('equipos') ? count(old('equipos')) : 0 }}; // Inicia el índice

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
                            <div class="form-group">
                                <label for="idequipo_${equipmentIndex}">Seleccionar Equipo:</label>
                                <select name="equipos[${equipmentIndex}][idequipo]" id="idequipo_${equipmentIndex}" class="form-control @error('equipos.${equipmentIndex}.idequipo') is-invalid @enderror" required>
                                    <option value="">Seleccione un equipo</option>
                                    @foreach($equipos as $equipo)
                                        <option value="{{ $equipo->idequipo }}">{{ $equipo->codequipo }} - {{ $equipo->descripcion }} - {{ $equipo->numserial }}</option>
                                    @endforeach
                                </select>
                                @error('equipos.${equipmentIndex}.idequipo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="fechaentrega_${equipmentIndex}">Fecha de Entrega:</label>
                                <input type="date" name="equipos[${equipmentIndex}][fechaentrega]" id="fechaentrega_${equipmentIndex}" class="form-control ('equipos.${equipmentIndex}.fechaentrega') required>
                                @error('equipos.${equipmentIndex}.fechaentrega')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="fechadevolucion_${equipmentIndex}">Fecha de Devolución (Detalle):</label>
                                <input type="date" name="equipos[${equipmentIndex}][fechadevolucion]" id="fechadevolucion_${equipmentIndex}" class="form-control ('equipos.${equipmentIndex}.fechadevolucion') }}">
                                @error('equipos.${equipmentIndex}.fechadevolucion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="observacionentrega_${equipmentIndex}">Observación de Entrega:</label>
                                <input type="text" name="equipos[${equipmentIndex}][observacionentrega]" id="observacionentrega_${equipmentIndex}" class="form-control ('equipos.${equipmentIndex}.observacionentrega') }}" maxlength="100" required> {{-- Añadido required --}}
                                @error('equipos.${equipmentIndex}.observacionentrega')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="observaciondevolucion_${equipmentIndex}">Observación de Devolución:</label>
                                <input type="text" name="equipos[${equipmentIndex}][observaciondevolucion]" id="observaciondevolucion_${equipmentIndex}" class="form-control ('equipos.${equipmentIndex}.observaciondevolucion') }}" maxlength="100" required> {{-- Añadido required --}}
                                @error('equipos.${equipmentIndex}.observaciondevolucion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="estado_detalle_${equipmentIndex}">Estado del Detalle:</label>
                                <select name="equipos[${equipmentIndex}][estado_detalle]" id="estado_detalle_${equipmentIndex}" class="form-control @error('equipos.${equipmentIndex}.estado_detalle') is-invalid @enderror" required>
                                    {{-- Ajusta estos valores según tu ENUM en la migración de detalleprestamo --}}
                                    <option value="entregado" {{ old('equipos.', '.estado_detalle') == 'entregado' ? 'selected' : '' }}>Entregado</option>
                                    <option value="devuelto" {{ old('equipos.', '.estado_detalle') == 'devuelto' ? 'selected' : '' }}>Devuelto</option>
                                    <option value="pendiente_devolucion" {{ old('equipos.', '.estado_detalle') == 'pendiente_devolucion' ? 'selected' : '' }}>Pendiente Devolución</option>
                                    <option value="danado" {{ old('equipos.', '.estado_detalle') == 'danado' ? 'selected' : '' }}>Dañado</option>
                                </select>
                                @error('equipos.${equipmentIndex}.estado_detalle')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                `;
                const newRowElement = document.createElement('div');
                newRowElement.innerHTML = template.trim();
                equiposContainer.appendChild(newRowElement.firstChild); // Añadir la fila
                equipmentIndex++;

                // Adjuntar listener al nuevo botón de eliminar
                newRowElement.querySelector('.remove-equipment-row').addEventListener('click', function() {
                    this.closest('.equipment-row').remove();
                    // Opcional: Reindexar los campos si necesitas índices consecutivos,
                    // pero Laravel maneja bien los arrays con índices no consecutivos al guardar.
                });
            }

            // Si no hay equipos precargados y la página carga, añadir una primera fila
            // if (equipmentIndex === 0 && !old('equipos')) {
            //     addEquipmentRow();
            // }

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