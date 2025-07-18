<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script> --}}
</head>

<body>
<h1>Actualizar solicitud de Mantenimiento</h1>
<form method="POST" action="{{ route('solimantenimiento.update', ['idsolicitud' => $solimantenimiento->idsolicitud]) }}">     
    @csrf @method('PUT')
    <label for="fechasolicitud">Fecha de solicitud:</label>
    <input type="date" name="fechasolicitud" id="fechasolicitud" value="{{ $solimantenimiento->fechasolicitud }}" required>
    <br>
    <div class="form-group">
        <label>Equipos:</label>
        <select name="idequipo" class="form-control @error('idequipo') is-invalid @enderror">
            <option value="">Seleccione un equipo</option>
            @foreach($equipos as $equipo)
                <option value="{{ $equipo->idequipo }}" 
                    {{ old('idequipo', $solimantenimiento->numserial) == $solimantenimiento->numserial ? 'selected' : '' }}>
                    {{ $equipo->descripcion }} - {{ $equipo->numserial }}</option>
            @endforeach
        </select>
        @error('idequipo')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <label for="descripcion">Descripción:</label>
    <input type="text" name="descripcion" id="descripcion" value="{{ $solimantenimiento->descripcion }}" required>
    <br>
    <label for="fechacierre">Fecha de cierre:</label>
    <input type="date" name="fechacierre" id="fechacierre" value="{{ $solimantenimiento->fechacierre }}" required>
    <br>
     <!-- Selector de Usuario -->
    <div class="form-group">
        <label>Usuario:</label>
        <select name="idusuario" class="form-control @error('idusuario') is-invalid @enderror" >
            <option value="">Seleccione un usuario</option>
            @foreach($usuarios as $usuario)
                <option value="{{ $usuario->idusuario }}" 
                    {{ old('idusuario', $solimantenimiento->nomusuario) == $solimantenimiento->nomcompleto ? 'selected' : '' }}>
                    {{ $usuario->nomusuario }} - {{ $usuario->nomcompleto }} 
                </option>
            @endforeach
        </select>
        @error('idusuario')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <label for="estado">Estado:</label>
    <input type="text" name="estado" id="estado" value="{{ $solimantenimiento->estado }}" required>
    <br>
    <input type="hidden" name="idsolicitud" id="idsolicitud" value="{{ $solimantenimiento->idsolicitud }}">
    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="{{ route('solimantenimiento.index') }}" method="GET" class="btn btn-secondary">Regresar</a>
</form>
</body>
</html>