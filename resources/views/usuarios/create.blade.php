@extends('layouts.app')

@section('content')

<div class="container">

    <h3>Crear Usuario</h3>

    <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Contraseña</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Rol</label>
            <select name="rol" class="form-control" required>
                <option value="Operario">Operario</option>
                <option value="Administrador">Administrador</option>
            </select>
        </div>

        <button class="btn btn-success">Guardar</button>

    </form>

</div>

@endsection