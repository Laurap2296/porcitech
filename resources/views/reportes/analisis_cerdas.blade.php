@extends('layouts.app')

@section('title', 'Análisis de Cerdas Reproductoras')

@section('content')

<div class="container-fluid">

    <div class="card shadow mb-4">

        {{-- ENCABEZADO --}}
        <div class="card-header bg-success text-white">

            <h4 class="mb-0">

                <i class="bi bi-graph-up-arrow"></i>

                Análisis de Cerdas Reproductoras

            </h4>

        </div>


        <div class="card-body">


            {{-- ========================================================= --}}
            {{-- FILTROS --}}
            {{-- ========================================================= --}}

            <form
                method="GET"
                action="{{ url('/reportes/analisis-cerdas') }}"
                class="mb-4"
            >

                <div class="row g-3">

                    {{-- CERDA --}}

                    <div class="col-md-4">

                        <label class="form-label">

                            <strong>Cerda</strong>

                        </label>

                        <select
                            name="hembra_id"
                            class="form-select"
                        >

                            <option value="">

                                Todas las cerdas

                            </option>

                            @foreach($hembras as $hembra)

                                <option
                                    value="{{ $hembra->id }}"
                                    {{ request('hembra_id') == $hembra->id ? 'selected' : '' }}
                                >

                                    {{ $hembra->codigo }}

                                    @if($hembra->raza)

                                        - {{ $hembra->raza }}

                                    @endif

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- FECHA DESDE --}}

                    <div class="col-md-3">

                        <label class="form-label">

                            <strong>Fecha desde</strong>

                        </label>

                        <input
                            type="date"
                            name="fecha_desde"
                            class="form-control"
                            value="{{ request('fecha_desde') }}"
                        >

                    </div>


                    {{-- FECHA HASTA --}}

                    <div class="col-md-3">

                        <label class="form-label">

                            <strong>Fecha hasta</strong>

                        </label>

                        <input
                            type="date"
                            name="fecha_hasta"
                            class="form-control"
                            value="{{ request('fecha_hasta') }}"
                        >

                    </div>


                    {{-- BOTONES --}}

                    <div class="col-md-2 d-flex align-items-end">

                        <div class="d-flex gap-2 w-100">

                            {{-- FILTRAR --}}

                            <button
                                type="submit"
                                class="btn btn-primary"
                                title="Aplicar filtros"
                            >

                                <i class="bi bi-funnel"></i>

                                Filtrar

                            </button>


                            {{-- LIMPIAR --}}

                            <a
                                href="{{ url('/reportes/analisis-cerdas') }}"
                                class="btn btn-secondary"
                                title="Limpiar filtros"
                            >

                                <i class="bi bi-x-circle"></i>

                            </a>

                        </div>

                    </div>

                </div>

            </form>


            {{-- ========================================================= --}}
            {{-- BOTONES DE ACCIÓN --}}
            {{-- ========================================================= --}}

            <div class="d-flex justify-content-between align-items-center mb-3">

                {{-- REGRESAR --}}

                <a
                    href="{{ url('/reportes') }}"
                    class="btn btn-secondary"
                >

                    <i class="bi bi-arrow-left"></i>

                    Regresar

                </a>


                {{-- PDF --}}

                <a
                    href="{{ route('reportes.analisis.pdf', request()->query()) }}"
                    class="btn btn-danger"
                >

                    <i class="bi bi-file-earmark-pdf"></i>

                    PDF

                </a>

            </div>


            {{-- ========================================================= --}}
            {{-- INDICADORES GENERALES --}}
            {{-- ========================================================= --}}

            <div class="row mb-4">


                {{-- CERDAS EVALUADAS --}}

                <div class="col-md-3">

                    <div class="card bg-success text-white shadow">

                        <div class="card-body">

                            <h6>

                                Cerdas Evaluadas

                            </h6>

                            <h2>

                                {{ $cerdas->count() }}

                            </h2>

                        </div>

                    </div>

                </div>


                {{-- SERVICIOS --}}

                <div class="col-md-3">

                    <div class="card bg-primary text-white shadow">

                        <div class="card-body">

                            <h6>

                                Total Servicios

                            </h6>

                            <h2>

                                {{ $cerdas->sum('servicios') }}

                            </h2>

                        </div>

                    </div>

                </div>


                {{-- PARTOS --}}

                <div class="col-md-3">

                    <div class="card bg-warning text-dark shadow">

                        <div class="card-body">

                            <h6>

                                Total Partos

                            </h6>

                            <h2>

                                {{ $cerdas->sum('partos') }}

                            </h2>

                        </div>

                    </div>

                </div>


                {{-- CRÍAS VIVAS --}}

                <div class="col-md-3">

                    <div class="card bg-danger text-white shadow">

                        <div class="card-body">

                            <h6>

                                Crías Vivas

                            </h6>

                            <h2>

                                {{ $cerdas->sum('vivas') }}

                            </h2>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- TABLA --}}
            {{-- ========================================================= --}}

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="table-success">

                        <tr>

                            <th>
                                Ranking
                            </th>

                            <th>
                                Código Cerda
                            </th>

                            <th>
                                Raza
                            </th>

                            <th>
                                Servicios
                            </th>

                            <th>
                                Partos
                            </th>

                            <th>
                                Crías Totales
                            </th>

                            <th>
                                Crías Vivas
                            </th>

                            <th>
                                Crías Muertas
                            </th>

                            <th>
                                Promedio Crías Vivas
                            </th>

                            <th>
                                Productividad
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                    @forelse($cerdas as $cerda)

                        <tr>

                            {{-- RANKING --}}

                            <td>

                                <span class="badge bg-success">

                                    #{{ $loop->iteration }}

                                </span>

                            </td>


                            {{-- CÓDIGO --}}

                            <td>

                                {{ $cerda->codigo }}

                            </td>


                            {{-- RAZA --}}

                            <td>

                                {{ $cerda->raza ?? 'N/A' }}

                            </td>


                            {{-- SERVICIOS --}}

                            <td>

                                {{ $cerda->servicios }}

                            </td>


                            {{-- PARTOS --}}

                            <td>

                                {{ $cerda->partos }}

                            </td>


                            {{-- CRÍAS TOTALES --}}

                            <td>

                                {{ $cerda->total_crias ?? 0 }}

                            </td>


                            {{-- CRÍAS VIVAS --}}

                            <td>

                                <span class="badge bg-success">

                                    {{ $cerda->vivas ?? 0 }}

                                </span>

                            </td>


                            {{-- CRÍAS MUERTAS --}}

                            <td>

                                {{ $cerda->muertas ?? 0 }}

                            </td>


                            {{-- PROMEDIO --}}

                            <td>

                                {{ number_format($cerda->promedio ?? 0, 2) }}

                            </td>


                            {{-- PRODUCTIVIDAD --}}

                            <td>

                                @if($cerda->partos > 0)

                                    @php

                                        $productividad =
                                            ($cerda->vivas / $cerda->partos);

                                    @endphp

                                    <span class="badge bg-primary">

                                        {{ number_format($productividad, 2) }}

                                        crías/parto

                                    </span>

                                @else

                                    <span class="badge bg-secondary">

                                        Sin partos

                                    </span>

                                @endif

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="10"
                                class="text-center"
                            >

                                No existen datos de análisis reproductivo.

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