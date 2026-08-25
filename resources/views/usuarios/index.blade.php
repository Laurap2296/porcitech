@extends('layouts.app')

@section('content')

<div class="container">

    <h3>Gestión de Usuarios</h3>

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
            @foreach($usuarios as $u)
            <tr>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ $u->rol }}</td>

                <td>

                    <!-- EDITAR -->
                    <a href="{{ route('usuarios.edit', $u->id) }}"
                       class="btn btn-warning btn-sm">
                        ✏️ Editar
                    </a>

                    <!-- ELIMINAR -->
                    <form action="{{ route('usuarios.destroy', $u->id) }}"
                          method="POST"
                          style="display:inline;">

                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger btn-sm"
                                onclick="return confirm('¿Eliminar usuario?')">
                            🗑 Eliminar
                        </button>

                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>

    </table>

</div>

@endsection