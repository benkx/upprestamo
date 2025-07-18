@extends('adminlte::page') {{-- Cambiar a layout de AdminLTE --}}

@section('title', 'Ubicación') {{-- Título para pestaña del navegador --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear</title>
</head>
<body>
    @section('content_header') {{-- Sección específica de AdminLTE para el encabezado --}}
    <h1>Crear Solicitud de Mantenimiento</h1>
    <form action="{{ route('solimantenimiento.store') }}" method="POST">     
        @csrf 
        <div class="col-6">
        <label for="fechasolicitud">Fecha de solicitud:</label>
        <input type="date" class="form-control" name="fechasolicitud" id="fechasolicitud" required>
        <br>
        <div class="form-group">
        <label>Equipos:</label>
        <select name="idequipo" class="form-control @error('idequipo') is-invalid @enderror">
            <option value="">Seleccione un equipo</option>
            @foreach($equipos as $equipo)
                <option value="{{ $equipo->idequipo }}" 
                    {{ old('idequipo') == $equipo->codequipo ? 'selected' : '' }}>
                    {{ $equipo->descripcion }} - {{ $equipo->numserial }}</option>
            @endforeach
        </select>
        @error('idequipo')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        </div>
        <label for="descripcion">Descripción:</label>
        <input type="text" class="form-control" name="descripcion" id="descripcion" required>
        <br>
        <label for="fechacierre">Fecha de cierre:</label>
        <input type="date" class="form-control" name="fechacierre" id="fechacierre" required>
        <br>
         <!-- Selector de Usuario -->
    <div class="form-group">
        <label>Usuario:</label>
        <select name="idusuario" class="form-control @error('idusuario') is-invalid @enderror">
            <option value="">Seleccione un usuario</option>
            @foreach($usuarios as $usuario)
                <option value="{{ $usuario->idusuario }}" 
                    {{ old('idusuario') == $usuario->id ? 'selected' : '' }}>
                    {{ $usuario->nomusuario }} - {{ $usuario->nomcompleto }}
                </option>
            @endforeach
        </select>
        @error('idusuario')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
      
        <label for="estado">Estado:</label>
        <input type="text" class="form-control" name="estado" id="estado" required>
        <br>
        <button type="submit" class="btn btn-primary">Crear</button>
        <a href="{{ route('solimantenimiento.index') }}" method="GET" class="btn btn-secondary">Regresar</a>
        </div>
    </form> 
</body>
</html>
@stop