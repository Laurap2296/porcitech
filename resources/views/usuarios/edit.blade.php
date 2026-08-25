@extends('layouts.app')

@section('content')

<div class="container">

    <h3>Editar Usuario</h3>

    <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="name" value="{{ $usuario->name }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ $usuario->email }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Rol</label>
            <select name="rol" class="form-control">
                <option value="Administrador" {{ $usuario->rol == 'Administrador' ? 'selected' : '' }}>
                    Administrador
                </option>

                <option value="Operario" {{ $usuario->rol == 'Operario' ? 'selected' : '' }}>
                    Operario
                </option>
            </select>
        </div>

        <button class="btn btn-primary">Actualizar</button>

    </form>

</div>

@endsection