@extends('adminlte::page') {{-- Cambiar a layout de AdminLTE --}}

@section('title', 'Usuarios') {{-- Título para pestaña del navegador --}}

@section('content_header') {{-- Sección específica de AdminLTE para el encabezado --}}
    <h1>Usuarios
        <a href="{{ route('usuarios.create') }}" class="btn btn-success btn-sm">
            <i class="fas fa-plus-circle"></i> Nuevo
        </a>
    </h1>
@stop

@section('content') {{-- Contenido principal debe usar esta sección --}}
<!DOCTYPE html>
<html>
<head>
    <title>Usuarios</title>
</head>
<body>
    <h1>Vista de Usuario</h1>

    <table border="1">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre de Usuario</th>
                <th>Contraseña</th>
                <th>Nombre Completo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->idusuario }}</td>
                    <td>{{ $usuario->nomusuario }}</td>
                    {{-- <td>**********</td> --}}
                    <td>{{ $usuario->contrasena }}</td>
                    <td>{{ $usuario->nomcompleto }}</td>
                    <td>{{ $usuario->estado }}</td>
                    <td>
                    
                        <a href="{{ route('usuarios.edit', $usuario->idusuario) }}" class="btn btn-primary">Editar</a>
                        <form action="{{ route('usuarios.destroy', $usuario->idusuario) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
</body>
</html>
@stop