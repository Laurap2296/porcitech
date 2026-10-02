@extends('layouts.app')

@section('content')

<div class="container">

    <h3>Editar Usuario</h3>

    <form action="{{ route('usuarios.update', $usuario->id) }}"
          method="POST">

        @csrf
        @method('PUT')

        {{-- ERRORES DE VALIDACIÓN --}}
        @if($errors->any())
            <div class="alert alert-danger">

                <strong>⚠ Por favor, corrige los siguientes errores:</strong>

                <ul class="mb-0 mt-2">

                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>
        @endif

        {{-- NOMBRE --}}
        <div class="mb-3">

            <label for="name" class="form-label">
                Nombre
            </label>

            <input type="text"
                   id="name"
                   name="name"
                   value="{{ old('name', $usuario->name) }}"
                   class="form-control"
                   required>

        </div>

        {{-- EMAIL --}}
        <div class="mb-3">

            <label for="email" class="form-label">
                Email
            </label>

            <input type="email"
                   id="email"
                   name="email"
                   value="{{ old('email', $usuario->email) }}"
                   class="form-control"
                   required>

        </div>

        {{-- ROL --}}
        <div class="mb-3">

            <label for="rol" class="form-label">
                Rol
            </label>

            <select id="rol"
                    name="rol"
                    class="form-control"
                    required>

                <option value="Administrador"
                    {{ old('rol', $usuario->rol) == 'Administrador' ? 'selected' : '' }}>
                    Administrador
                </option>

                <option value="Operario"
                    {{ old('rol', $usuario->rol) == 'Operario' ? 'selected' : '' }}>
                    Operario
                </option>

            </select>

        </div>

        {{-- BOTONES --}}
        <div class="d-flex gap-2">

            <a href="{{ route('usuarios.index') }}"
               class="btn btn-secondary">
                ← Volver
            </a>

            <button type="submit"
                    class="btn btn-primary">
                ✏️ Actualizar Usuario
            </button>

        </div>

    </form>

</div>

@endsection