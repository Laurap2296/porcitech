@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Gestión de Ventas</h2>

        <a href="{{ route('ventas.create') }}" class="btn btn-success">
            + Nueva Venta
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <table class="table table-bordered table-hover">

        <thead class="table-success">

            <tr>

                <th>ID</th>
                <th>Animal</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Peso</th>
                <th>Precio/Kg</th>
                <th>Total</th>
                <th>Acciones</th>

            </tr>

        </thead>

        <tbody>

            @forelse($ventas as $venta)

            <tr>

                <td>{{ $venta->id }}</td>

                <td>{{ $venta->animal->codigo }}</td>

                <td>{{ $venta->cliente }}</td>

                <td>{{ $venta->fecha_venta }}</td>

                <td>{{ $venta->peso_venta }} Kg</td>

                <td>${{ number_format($venta->precio_kilo,0,',','.') }}</td>

                <td>${{ number_format($venta->total_venta,0,',','.') }}</td>

                <td>

                    <a href="{{ route('ventas.show',$venta->id) }}" class="btn btn-info btn-sm">
                        Ver
                    </a>

                    <a href="{{ route('ventas.edit',$venta->id) }}" class="btn btn-warning btn-sm">
                        Editar
                    </a>

                    <form action="{{ route('ventas.destroy',$venta->id) }}" method="POST" class="d-inline">

                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger btn-sm"
                            onclick="return confirm('¿Desea eliminar esta venta?')">

                            Eliminar

                        </button>

                    </form>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="8" class="text-center">

                    No existen ventas registradas.

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>
@endsection