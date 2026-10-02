@extends('layouts.app')

@section('content')

<div class="container">

    <h3>Gestión de Usuarios</h3>

    {{-- MENSAJE DE ÉXITO --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>✓ ¡Éxito!</strong>
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Cerrar">
            </button>
        </div>
    @endif

    {{-- MENSAJE DE ERROR --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>⚠ Atención:</strong>
            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Cerrar">
            </button>
        </div>
    @endif

    <a href="{{ route('usuarios.create') }}" class="btn btn-success mb-3">
        ➕ Crear Usuario
    </a>

    <table class="table table-bordered">

        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>

            @forelse($usuarios as $u)

            <tr>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ $u->rol }}</td>

                <td>

                    {{-- EDITAR --}}
                    <a href="{{ route('usuarios.edit', $u->id) }}"
                       class="btn btn-warning btn-sm">
                        ✏️ Editar
                    </a>

                    {{-- ELIMINAR --}}
                    <form action="{{ route('usuarios.destroy', $u->id) }}"
                          method="POST"
                          style="display:inline;">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('¿Está seguro de eliminar este usuario?')">
                            🗑 Eliminar
                        </button>

                    </form>

                </td>
            </tr>

            @empty

            <tr>
                <td colspan="4" class="text-center">
                    No hay usuarios registrados.
                </td>
            </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection