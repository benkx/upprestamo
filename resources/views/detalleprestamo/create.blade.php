@extends('adminlte::page') {{-- Cambiar a layout de AdminLTE --}}

@section('title', 'Detalle Prestamo') {{-- Título para pestaña del navegador --}}

<body>
    @section('content_header') {{-- Sección específica de AdminLTE para el encabezado --}}
    <h1>Detalle del prestamo</h1>
    <form action="{{ route('detalleprestamo.store') }}" method="POST">     
        @csrf 
        <div class="col-6">
            <div class="form-group">
                <label>ID Prestamo:</label>
                <select name="idprestamo" id="prestamo" class="form-control @error('idprestamo') is-invalid @enderror">
                    <option value="">Seleccione un prestamo</option>
                    @foreach($prestamos as $prestamo)
                        <option value="{{ $prestamo->idprestamo }}"
                            {{ old('idprestamo') == $prestamo->idprestamo ? 'selected' : '' }}>
                            {{ $prestamo->idprestamo }} - {{ $prestamo->idprestamo }}
                        </option>
                    @endforeach
                </select>
                @error('idprestamo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>ID Equipo:</label>
                <select name="idequipo" id="equipo" class="form-control @error('idequipo') is-invalid @enderror">
                    <option value="">Seleccione un equipo</option>
                    @foreach($equipos as $equipo)
                        <option value="{{ $equipo->idequipo }}"
                            {{ old('idequipo') == $equipo->idequipo ? 'selected' : '' }}>
                            {{ $equipo->idequipo }} - {{ $equipo->descripcion }} - {{ $equipo->tipoequipo }}
                        </option>
                    @endforeach
                </select>
                @error('idequipo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            <br>
            <label for="estado">Estado:</label>
            <input type="text" class="form-control" name="estado" id="estado" required>
            <br>
            <button type="submit" class="btn btn-primary">Crear</button>
            <a href="{{ route('periodoacademico.index') }}" method="GET" class="btn btn-secondary">Regresar</a>
        </div>
    </form> 
</body>
</html>
@stop
