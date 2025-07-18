@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <label>Nombre de Usuario:</label>
            <input type="text" id="nomusuario" name="nomusuario" value="{{ old('nomusuario') }}" model="nomusuario" required autofocus>
        </div>

        <div>
            <label>Contraseña:</label>
            <input type="password" name="contrasena"  id="contrasena" model="contrasena" required>
        </div>

        <button type="submit">Ingresar</button>
    </form>

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif
</body>
</html>