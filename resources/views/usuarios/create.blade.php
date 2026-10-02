@extends('layouts.app')

@section('content')

<div class="container">

    <h3>Crear Usuario</h3>

    <form action="{{ route('usuarios.store') }}"
          method="POST"
          autocomplete="off">

        @csrf

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
                   value="{{ old('name') }}"
                   class="form-control"
                   autocomplete="off"
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
                   value="{{ old('email') }}"
                   class="form-control"
                   autocomplete="off"
                   required>

        </div>

        {{-- CONTRASEÑA --}}
        <div class="mb-3">

            <label for="password" class="form-label">
                Contraseña
            </label>

            <input type="password"
                   id="password"
                   name="password"
                   class="form-control"
                   autocomplete="new-password"
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

                <option value="Operario"
                    {{ old('rol') == 'Operario' ? 'selected' : '' }}>
                    Operario
                </option>

                <option value="Administrador"
                    {{ old('rol') == 'Administrador' ? 'selected' : '' }}>
                    Administrador
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
                    class="btn btn-success">
                💾 Guardar Usuario
            </button>

        </div>

    </form>

</div>

@endsection