@extends('layouts.app')

@section('title', 'Reporte de Ventas')

@section('content')

<div class="container-fluid">

    <div class="card shadow mb-4">

        <div class="card-header bg-success text-white">

            <h4 class="mb-0">
                <i class="bi bi-cart-check"></i>
                Reporte de Ventas
            </h4>

        </div>

        <div class="card-body">

            {{-- FILTROS --}}
            <form method="GET"
                  action="{{ route('reportes.ventas') }}"
                  class="mb-4">

                <div class="row g-3">

                    {{-- Animal --}}
                    <div class="col-md-4">

                        <label class="form-label fw-bold">
                            Animal
                        </label>

                        <select name="animal_id"
                                class="form-select">

                            <option value="">
                                Todos los animales
                            </option>

                            @foreach($animales as $animal)

                                <option value="{{ $animal->id }}"
                                    {{ request('animal_id') == $animal->id ? 'selected' : '' }}>

                                    {{ $animal->codigo }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Fecha desde --}}
                    <div class="col-md-3">

                        <label class="form-label fw-bold">
                            Fecha desde
                        </label>

                        <input type="date"
                               name="fecha_desde"
                               class="form-control"
                               value="{{ request('fecha_desde') }}">

                    </div>


                    {{-- Fecha hasta --}}
                    <div class="col-md-3">

                        <label class="form-label fw-bold">
                            Fecha hasta
                        </label>

                        <input type="date"
                               name="fecha_hasta"
                               class="form-control"
                               value="{{ request('fecha_hasta') }}">

                    </div>


                    {{-- Botones --}}
                    <div class="col-md-2 d-flex align-items-end gap-2">

                        <button type="submit"
                                class="btn btn-primary">

                            <i class="bi bi-funnel"></i>
                            Filtrar

                        </button>

                        <a href="{{ route('reportes.ventas') }}"
                           class="btn btn-secondary">

                            <i class="bi bi-x-circle"></i>

                        </a>

                    </div>

                </div>

            </form>


            {{-- RESUMEN --}}
            <div class="row mb-4">

                <div class="col-md-4">

                    <div class="card bg-success text-white shadow">

                        <div class="card-body">

                            <h6>
                                Total Ventas
                            </h6>

                            <h2>
                                {{ $ventas->count() }}
                            </h2>

                        </div>

                    </div>

                </div>


                <div class="col-md-4">

                    <div class="card bg-primary text-white shadow">

                        <div class="card-body">

                            <h6>
                                Animales Vendidos
                            </h6>

                            <h2>
                                {{ $ventas->pluck('animal_id')->unique()->count() }}
                            </h2>

                        </div>

                    </div>

                </div>


                <div class="col-md-4">

                    <div class="card bg-warning text-dark shadow">

                        <div class="card-body">

                            <h6>
                                Ingresos Totales
                            </h6>

                            <h4>

                                $
                                {{ number_format(
                                    $ventas->sum('total_venta'),
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </h4>

                        </div>

                    </div>

                </div>

            </div>


            {{-- EXPORTAR Y REGRESAR --}}
            <div class="d-flex justify-content-between mb-3">

                <a href="{{ route('reportes.index') }}"
                   class="btn btn-secondary">

                    <i class="bi bi-arrow-left"></i>
                    Regresar a Reportes

                </a>


                <div>

                    {{-- PDF --}}
                    <a href="{{ route(
                        'reportes.ventas.pdf',
                        request()->query()
                    ) }}"
                       class="btn btn-danger">

                        <i class="bi bi-file-earmark-pdf"></i>
                        PDF

                    </a>

                </div>

            </div>


            {{-- TABLA --}}
            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="table-success">

                        <tr>

                            <th>#</th>

                            <th>Animal</th>

                            <th>Cliente</th>

                            <th>Documento</th>

                            <th>Teléfono</th>

                            <th>Fecha Venta</th>

                            <th>Peso Venta</th>

                            <th>Precio/Kg</th>

                            <th>Total Venta</th>

                        </tr>

                    </thead>


                    <tbody>

                    @forelse($ventas as $venta)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>


                            <td>

                                @if($venta->animal)

                                    <strong>
                                        {{ $venta->animal->codigo }}
                                    </strong>

                                @else

                                    Sin animal

                                @endif

                            </td>


                            <td>
                                {{ $venta->cliente }}
                            </td>


                            <td>
                                {{ $venta->documento_cliente ?? 'N/A' }}
                            </td>


                            <td>
                                {{ $venta->telefono_cliente ?? 'N/A' }}
                            </td>


                            <td>

                                {{ \Carbon\Carbon::parse(
                                    $venta->fecha_venta
                                )->format('d/m/Y') }}

                            </td>


                            <td>

                                {{ number_format(
                                    $venta->peso_venta,
                                    2
                                ) }}

                                Kg

                            </td>


                            <td>

                                $

                                {{ number_format(
                                    $venta->precio_kilo,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </td>


                            <td>

                                <strong>

                                    $

                                    {{ number_format(
                                        $venta->total_venta,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                </strong>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="9"
                                class="text-center">

                                No existen ventas registradas
                                con los filtros seleccionados.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection