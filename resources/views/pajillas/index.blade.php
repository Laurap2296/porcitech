@extends('layouts.app')

@section('content')

<div class="container">

<h2>Pajillas</h2>

<a href="{{ route('pajillas.create') }}"
   class="btn btn-primary mb-3">
   Nueva Pajilla
</a>

<table class="table table-bordered">

<thead>

<tr>
    <th>ID</th>
    <th>Código</th>
    <th>Raza</th>
    <th>Línea Genética</th>
    <th>Estado</th>
    <th>Acciones</th>
</tr>

</thead>

<tbody>

@foreach($pajillas as $p)

<tr>

    <td>{{ $p->id }}</td>

    <td>{{ $p->codigo_pajilla }}</td>

    <td>{{ $p->raza }}</td>

    <td>{{ $p->linea_genetica }}</td>

    <td>{{ $p->estado }}</td>

    <td>

        <a href="{{ route('pajillas.show', $p->id) }}"
           class="btn btn-info btn-sm">
           Ver
        </a>

        <a href="{{ route('pajillas.edit', $p->id) }}"
           class="btn btn-warning btn-sm">
           Editar
        </a>

        <form action="{{ route('pajillas.destroy', $p->id) }}"
              method="POST"
              style="display:inline">

            @csrf
            @method('DELETE')

            <button class="btn btn-danger btn-sm">
                Eliminar
            </button>

        </form>

    </td>

</tr>

@endforeach

</tbody>

</table>

</div>

@endsection