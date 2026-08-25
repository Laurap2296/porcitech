@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h2>Granjas</h2>

    <a href="{{ route('granjas.create') }}" class="btn btn-success">
        Nueva Granja
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<table class="table table-bordered table-striped">

    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Ubicación</th>
            <th>Propietario</th>
            <th>Teléfono</th>
            <th>Estado</th>
            <th width="220">Acciones</th>
        </tr>
    </thead>

    <tbody>

        @forelse($granjas as $granja)

        <tr>
            <td>{{ $granja->id }}</td>
            <td>{{ $granja->nombre }}</td>
            <td>{{ $granja->ubicacion }}</td>
            <td>{{ $granja->propietario }}</td>
            <td>{{ $granja->telefono }}</td>
            <td>{{ $granja->estado }}</td>

            <td>

                <a href="{{ route('granjas.show', $granja->id) }}"
                   class="btn btn-info btn-sm">
                    Ver
                </a>

                <a href="{{ route('granjas.edit', $granja->id) }}"
                   class="btn btn-warning btn-sm">
                    Editar
                </a>

                <form action="{{ route('granjas.destroy', $granja->id) }}"
                      method="POST"
                      style="display:inline;">

                    @csrf
                    @method('DELETE')

                    <button class="btn btn-danger btn-sm">
                        Eliminar
                    </button>

                </form>

            </td>

        </tr>

        @empty

        <tr>
            <td colspan="7" class="text-center">
                No hay granjas registradas
            </td>
        </tr>

        @endforelse

    </tbody>

</table>

@endsection