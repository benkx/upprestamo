{{--
    Este parcial se usa para renderizar una fila de detalle de equipo en el formulario de préstamo.
    Variables pasadas: $index (el índice del array de equipos), $equipos (lista de equipos para el selector),
    $equipoDetalle (opcional, si hay datos viejos del formulario para precargar)
--}}
<div class="card card-secondary equipment-row mt-3" data-index="{{ $index }}">
    <div class="card-header">
        <h3 class="card-title">Equipo #{{ $index + 1 }}</h3>
        <div class="card-tools">
            {{-- Botón para quitar el equipo --}}
            <button type="button" class="btn btn-danger btn-sm remove-equipment-row" title="Quitar Equipo">
                <i class="fas fa-trash"></i> Quitar Equipo
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label for="idequipo_{{ $index }}">Seleccionar Equipo:</label>
            <select name="equipos[{{ $index }}][idequipo]" id="idequipo_{{ $index }}"
                    class="form-control @error('equipos.'.$index.'.idequipo') is-invalid @enderror" required>
                <option value="">Seleccione un equipo</option>
                @foreach($equipos as $equipo)
                    <option value="{{ $equipo->idequipo }}"
                        {{ (old('equipos.'.$index.'.idequipo') == $equipo->idequipo || (isset($equipoDetalle) && $equipoDetalle['idequipo'] == $equipo->idequipo)) ? 'selected' : '' }}>
                        {{ $equipo->codequipo }} - {{ $equipo->descripcion }} - {{ $equipo->numserial }}
                    </option>
                @endforeach
            </select>
            @error('equipos.'.$index.'.idequipo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="fechaentrega_{{ $index }}">Fecha de Entrega:</label>
            <input type="date" name="equipos[{{ $index }}][fechaentrega]" id="fechaentrega_${{ $index }}"
                   class="form-control @error('equipos.'.$index.'.fechaentrega') is-invalid @enderror"
                   value="{{ old('equipos.'.$index.'.fechaentrega', isset($equipoDetalle) ? $equipoDetalle['fechaentrega'] : '') }}" required>
            @error('equipos.'.$index.'.fechaentrega')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="fechadevolucion_{{ $index }}">Fecha de Devolución (Detalle):</label>
            <input type="date" name="equipos[{{ $index }}][fechadevolucion]" id="fechadevolucion_${{ $index }}"
                   class="form-control @error('equipos.'.$index.'.fechadevolucion') is-invalid @enderror"
                   value="{{ old('equipos.'.$index.'.fechadevolucion', isset($equipoDetalle) ? $equipoDetalle['fechadevolucion'] : '') }}">
            @error('equipos.'.$index.'.fechadevolucion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="observacionentrega_${{ $index }}">Observación de Entrega:</label>
            <input type="text" name="equipos[{{ $index }}][observacionentrega]" id="observacionentrega_${{ $index }}"
                   class="form-control @error('equipos.'.$index.'.observacionentrega') is-invalid @enderror"
                   value="{{ old('equipos.'.$index.'.observacionentrega', isset($equipoDetalle) ? $equipoDetalle['observacionentrega'] : '') }}" maxlength="100" required>
            @error('equipos.'.$index.'.observacionentrega')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="observaciondevolucion_${{ $index }}">Observación de Devolución:</label>
            <input type="text" name="equipos[{{ $index }}][observaciondevolucion]" id="observaciondevolucion_${{ $index }}"
                   class="form-control @error('equipos.'.$index.'.observaciondevolucion') is-invalid @enderror"
                   value="{{ old('equipos.'.$index.'.observaciondevolucion', isset($equipoDetalle) ? $equipoDetalle['observaciondevolucion'] : '') }}" maxlength="100" required>
            @error('equipos.'.$index.'.observaciondevolucion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="estado_detalle_${{ $index }}">Estado del Detalle:</label>
            <select name="equipos[{{ $index }}][estado_detalle]" id="estado_detalle_${{ $index }}"
                    class="form-control @error('equipos.'.$index.'.estado_detalle') is-invalid @enderror" required>
                {{-- Ajusta estos valores según tu ENUM en la migración de detalleprestamo --}}
                <option value="Entregado" {{ (old('equipos.'.$index.'.estado_detalle') == 'Entregado' || (isset($equipoDetalle) && $equipoDetalle['estado_detalle'] == 'Entregado')) ? 'selected' : '' }}>Entregado</option>
                <option value="Devuelto" {{ (old('equipos.'.$index.'.estado_detalle') == 'Devuelto' || (isset($equipoDetalle) && $equipoDetalle['estado_detalle'] == 'Devuelto')) ? 'selected' : '' }}>Devuelto</option>
                <option value="Vencido" {{ (old('equipos.'.$index.'.estado_detalle') == 'Vencido' || (isset($equipoDetalle) && $equipoDetalle['estado_detalle'] == 'Vencido')) ? 'selected' : '' }}>Vencido</option>
                <option value="Dañado" {{ (old('equipos.'.$index.'.estado_detalle') == 'Dañado' || (isset($equipoDetalle) && $equipoDetalle['estado_detalle'] == 'Dañado')) ? 'selected' : '' }}>Dañado</option>
            </select>
            @error('equipos.'.$index.'.estado_detalle')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>