
@extends('adminlte::page')

@section('title', 'Crear Préstamo')

@section('content_header')
    <h1>Crear Préstamo</h1>
@endsection

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Préstamo</title>

    {{-- Librerías requeridas por bootstrap-select --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.15/dist/js/bootstrap-select.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.15/dist/css/bootstrap-select.min.css">

</head>

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Nuevo Préstamo</h3>
        </div>

        <!-- ELEMENTO DE DATOS OCULTO: Inyección de JSON segura -->
        <div id="equipo-data-holder" data-equipos=@json(isset($equipos) ? $equipos : []) style="display: none;"></div>

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

                {{-- Campo Funcionario (Docente) --}}
                <div class="form-group">
                    <label for="select_funcionario">Funcionario (Docente)</label>
                    <select class="form-control @error('numdoc') is-invalid @enderror" 
                            data-size="5" 
                            data-live-search="true" 
                            id="select_funcionario" 
                            name="iddocente" 
                            required>
                        <option value="">Seleccione un Funcionario</option>
                        @foreach ($funcionarios as $funcionario)
                            {{-- CRÍTICO: Inyectamos el nombre para que JS lo lea. --}}
                            <option value="{{ $funcionario->numdoc }}" 
                                    data-nombre="{{ $funcionario->nombre_completo }}"
                                    {{ old('numdoc') == $funcionario->numdoc ? 'selected' : '' }}>
                                {{ $funcionario->numdoc }} ({{ $funcionario->nombre_completo }})
                            </option>
                        @endforeach
                    </select>
                    @error('numdoc') <p class="mt-1 text-sm text-danger">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label for="ubicacione">Nombre de la ubicación:</label>
                    <select name="idubicacion" id="ubicacione" class="form-control @error('idubicacion') is-invalid @enderror" required>
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
                    <input type="date" class="form-control datepicker @error('fechaprestamo') is-invalid @enderror" name="fechaprestamo" id="fechaprestamo" value="{{ old('fechaprestamo', date('Y-m-d')) }}" required>
                    @error('fechaprestamo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="periodoacademi">Periodo académico:</label>
                    <select name="idperoacademico" id="periodoacademi" class="form-control @error('idperoacademico') is-invalid @enderror" required>
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

                <!-- CAMPO OCULTO CRÍTICO: Si llega NULL es porque JS no lo está llenando. -->
                <input type="hidden" name="nomfuncionarios" id="nomfuncionarios_hidden" value="{{ old('nomfuncionarios') }}">

                <div class="form-group">
                    <label for="estado">Estado del Préstamo:</label>
                    <select class="form-control @error('estado') is-invalid @enderror" name="estado" id="estado" required>
                        <option value="Activo" {{ old('estado', 'Activo') == 'Activo' ? 'selected' : '' }}>Activo</option>
                        <option value="Vencido" {{ old('estado') == 'Vencido' ? 'selected' : '' }}>Vencido</option>
                        <option value="Finalizado" {{ old('estado') == 'Finalizado' ? 'selected' : '' }}>Finalizado</option>
                        <option value="Cancelado" {{ old('estado') == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
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
       
        // Al seleccionar un funcionario, actualizar el campo oculto con el nombre
            document.getElementById('select_funcionario').addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const nombreFuncionario = selectedOption.getAttribute('data-nombre') || '';
                document.getElementById('nomfuncionarios_hidden').value = nombreFuncionario;
            });

       document.addEventListener('DOMContentLoaded', function () {
       // --- Lógica para añadir/eliminar filas de equipo dinámicamente ---
            let equipmentIndex = {{ old('equipos') ? count(old('equipos')) : 1 }}; // Inicia el índice

            const equiposContainer = document.getElementById('equipos-container');
            const addEquipmentBtn = document.getElementById('add-equipment-btn');

            // Función para añadir una nueva fila de equipo
            function addEquipmentRow() {
                const template = `
                    <div class="card card-secondary equipment-row mt-3" data-index="${equipmentIndex}">
                        <div class="card-header">
                            <h3 class="card-title">Equipo #${equipmentIndex + 1}</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-danger btn-sm remove-equipment-row" title="Quitar Equipo"> 
                                    <i class="fas fa-times"></i> Quitar Equipo
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
                                <label for="observacionentrega_${equipmentIndex}">Observación de Entrega:</label>
                                <input type="text" name="equipos[${equipmentIndex}][observacionentrega]" id="observacionentrega_${equipmentIndex}" class="form-control ('equipos.${equipmentIndex}.observacionentrega') }}" maxlength="100" required> {{-- Añadido required --}}
                                @error('equipos.${equipmentIndex}.observacionentrega')
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

            // Al seleccionar un funcionario, actualizar el campo oculto con el nombre
            document.getElementById('select_funcionario').addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const nombreFuncionario = selectedOption.getAttribute('data-nombre') || '';
                document.getElementById('nomfuncionarios_hidden').value = nombreFuncionario;
            });

        });
    </script>
@stop