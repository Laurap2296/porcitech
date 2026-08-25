@extends('layouts.app')

@section('title', 'Reporte de Sanidad')

@section('content')

<div class="container-fluid">

    <div class="card shadow mb-4">

        {{-- ENCABEZADO --}}
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">

            <h4 class="mb-0">
                <i class="bi bi-heart-pulse"></i>
                Reporte de Sanidad
            </h4>

            <a href="{{ route('reportes.index') }}"
               class="btn btn-light btn-sm">

                <i class="bi bi-arrow-left"></i>
                Regresar a Reportes

            </a>

        </div>


        <div class="card-body">


            {{-- ========================================================= --}}
            {{-- FILTROS --}}
            {{-- ========================================================= --}}

            <form method="GET"
                  action="{{ route('reportes.sanidad') }}"
                  class="mb-4">

                <div class="card border-success">

                    <div class="card-header bg-light">

                        <strong>
                            <i class="bi bi-funnel"></i>
                            Filtros del reporte
                        </strong>

                    </div>


                    <div class="card-body">

                        <div class="row g-3">


                            {{-- ANIMAL --}}
                            <div class="col-md-3">

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


                            {{-- TIPO --}}
                            <div class="col-md-3">

                                <label class="form-label fw-bold">
                                    Tipo de registro
                                </label>

                                <select name="tipo_registro"
                                        class="form-select">

                                    <option value="">
                                        Todos los tipos
                                    </option>

                                    @foreach($tiposRegistro as $tipo)

                                        <option value="{{ $tipo }}"
                                            {{ request('tipo_registro') == $tipo ? 'selected' : '' }}>

                                            {{ $tipo }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            {{-- FECHA DESDE --}}
                            <div class="col-md-2">

                                <label class="form-label fw-bold">
                                    Desde
                                </label>

                                <input type="date"
                                       name="fecha_desde"
                                       class="form-control"
                                       value="{{ request('fecha_desde') }}">

                            </div>


                            {{-- FECHA HASTA --}}
                            <div class="col-md-2">

                                <label class="form-label fw-bold">
                                    Hasta
                                </label>

                                <input type="date"
                                       name="fecha_hasta"
                                       class="form-control"
                                       value="{{ request('fecha_hasta') }}">

                            </div>


                            {{-- BOTONES --}}
                            <div class="col-md-2 d-flex align-items-end">

                                <div class="d-flex gap-2 w-100">

                                    <button type="submit"
                                            class="btn btn-success w-100">

                                        <i class="bi bi-search"></i>
                                        Filtrar

                                    </button>


                                    <a href="{{ route('reportes.sanidad') }}"
                                       class="btn btn-secondary">

                                        <i class="bi bi-x-circle"></i>

                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </form>



            {{-- ========================================================= --}}
            {{-- RESUMEN --}}
            {{-- ========================================================= --}}

            <div class="row mb-4">


                {{-- REGISTROS --}}
                <div class="col-md-4">

                    <div class="card bg-success text-white shadow h-100">

                        <div class="card-body">

                            <h6>
                                Registros Sanitarios
                            </h6>

                            <h2 class="mb-0">

                                {{ $totalRegistros }}

                            </h2>

                        </div>

                    </div>

                </div>


                {{-- ANIMALES --}}
                <div class="col-md-4">

                    <div class="card bg-primary text-white shadow h-100">

                        <div class="card-body">

                            <h6>
                                Animales Atendidos
                            </h6>

                            <h2 class="mb-0">

                                {{ $totalAnimales }}

                            </h2>

                        </div>

                    </div>

                </div>


                {{-- PRÓXIMOS --}}
                <div class="col-md-4">

                    <div class="card bg-warning text-dark shadow h-100">

                        <div class="card-body">

                            <h6>
                                Próximos Controles
                            </h6>

                            <h2 class="mb-0">

                                {{ $proximosControles }}

                            </h2>

                        </div>

                    </div>

                </div>

            </div>



            {{-- ========================================================= --}}
            {{-- BOTÓN PDF --}}
            {{-- ========================================================= --}}

            <div class="d-flex justify-content-end mb-3">

                <a href="{{ route('reportes.sanidad.pdf', request()->query()) }}"
                   class="btn btn-danger">

                    <i class="bi bi-file-earmark-pdf"></i>

                    Exportar PDF

                </a>

            </div>



            {{-- ========================================================= --}}
            {{-- TABLA --}}
            {{-- ========================================================= --}}

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-success">

                        <tr>

                            <th style="width: 50px;">
                                #
                            </th>

                            <th style="width: 120px;">
                                Animal
                            </th>

                            <th>
                                Historial sanitario
                            </th>

                        </tr>

                    </thead>


                    <tbody>


                    @forelse($sanidadesAgrupadas as $animalId => $historial)

                        @php

                            $animal = $historial->first()->animal;

                        @endphp


                        <tr>


                            {{-- NÚMERO --}}
                            <td class="text-center fw-bold">

                                {{ $loop->iteration }}

                            </td>


                            {{-- ANIMAL --}}
                            <td class="text-center">

                                @if($animal)

                                    <span class="badge bg-dark fs-6">

                                        {{ $animal->codigo }}

                                    </span>

                                    <div class="small text-muted mt-1">

                                        {{ $animal->sexo ?? '' }}

                                    </div>

                                    <div class="small text-muted">

                                        {{ $animal->etapa ?? '' }}

                                    </div>

                                @else

                                    <span class="text-muted">
                                        Sin animal
                                    </span>

                                @endif

                            </td>


                            {{-- HISTORIAL --}}
                            <td>

                                @foreach($historial as $sanidad)

                                    <div class="border rounded p-3 mb-2 bg-light">


                                        <div class="row g-2">


                                            {{-- TIPO --}}
                                            <div class="col-md-2">

                                                <strong>
                                                    Tipo:
                                                </strong>

                                                <br>


                                                @if($sanidad->tipo_registro == 'Vacuna')

                                                    <span class="badge bg-success">
                                                        Vacuna
                                                    </span>

                                                @elseif($sanidad->tipo_registro == 'Tratamiento')

                                                    <span class="badge bg-warning text-dark">
                                                        Tratamiento
                                                    </span>

                                                @else

                                                    <span class="badge bg-primary">
                                                        {{ $sanidad->tipo_registro }}
                                                    </span>

                                                @endif

                                            </div>


                                            {{-- NOMBRE --}}
                                            <div class="col-md-2">

                                                <strong>
                                                    Nombre:
                                                </strong>

                                                <br>

                                                {{ $sanidad->nombre ?? 'N/A' }}

                                            </div>


                                            {{-- FECHA --}}
                                            <div class="col-md-2">

                                                <strong>
                                                    Fecha:
                                                </strong>

                                                <br>

                                                @if($sanidad->fecha)

                                                    {{ \Carbon\Carbon::parse($sanidad->fecha)->format('d/m/Y') }}

                                                @else

                                                    N/A

                                                @endif

                                            </div>


                                            {{-- PRÓXIMA FECHA --}}
                                            <div class="col-md-2">

                                                <strong>
                                                    Próximo control:
                                                </strong>

                                                <br>

                                                @if($sanidad->proxima_fecha)

                                                    {{ \Carbon\Carbon::parse($sanidad->proxima_fecha)->format('d/m/Y') }}

                                                @else

                                                    Sin fecha

                                                @endif

                                            </div>


                                            {{-- DIAGNÓSTICO --}}
                                            <div class="col-md-2">

                                                <strong>
                                                    Diagnóstico:
                                                </strong>

                                                <br>

                                                {{ $sanidad->diagnostico ?? 'Sin diagnóstico' }}

                                            </div>


                                            {{-- OBSERVACIONES --}}
                                            <div class="col-md-2">

                                                <strong>
                                                    Observaciones:
                                                </strong>

                                                <br>

                                                {{ $sanidad->observaciones ?? 'Sin observaciones' }}

                                            </div>

                                        </div>

                                    </div>

                                @endforeach

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td colspan="3"
                                class="text-center py-4">

                                <i class="bi bi-info-circle"></i>

                                No existen registros sanitarios
                                para los filtros seleccionados.

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