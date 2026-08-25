@extends('layouts.app')

@section('title', 'Reporte de Alimentación')

@section('content')

<div class="container-fluid">

    <div class="card shadow mb-4">

        {{-- ========================================================= --}}
        {{-- ENCABEZADO --}}
        {{-- ========================================================= --}}

        <div class="card-header bg-success text-white">

            <h4 class="mb-0">

                <i class="bi bi-egg-fried"></i>

                Reporte de Alimentación

            </h4>

        </div>


        <div class="card-body">


            {{-- ========================================================= --}}
            {{-- FILTROS --}}
            {{-- ========================================================= --}}

            <div class="card shadow-sm mb-4">

                <div class="card-header bg-light">

                    <strong>
                        <i class="bi bi-funnel"></i>
                        Filtros del reporte
                    </strong>

                </div>


                <div class="card-body">

                    <form method="GET"
                          action="{{ route('reportes.alimentacion') }}">

                        <div class="row g-3">


                            {{-- ANIMAL --}}
                            <div class="col-md-3">

                                <label for="animal_id"
                                       class="form-label fw-bold">

                                    Animal

                                </label>

                                <select name="animal_id"
                                        id="animal_id"
                                        class="form-select">

                                    <option value="">
                                        Todos los animales
                                    </option>

                                    @foreach($animalesFiltro as $animal)

                                        <option value="{{ $animal->id }}"
                                            {{ request('animal_id') == $animal->id ? 'selected' : '' }}>

                                            {{ $animal->codigo }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            {{-- SEXO --}}
                            <div class="col-md-3">

                                <label for="sexo"
                                       class="form-label fw-bold">

                                    Sexo

                                </label>

                                <select name="sexo"
                                        id="sexo"
                                        class="form-select">

                                    <option value="">
                                        Todos
                                    </option>

                                    @foreach($sexos as $sexo)

                                        <option value="{{ $sexo }}"
                                            {{ request('sexo') == $sexo ? 'selected' : '' }}>

                                            {{ $sexo }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            {{-- ETAPA --}}
                            <div class="col-md-3">

                                <label for="etapa"
                                       class="form-label fw-bold">

                                    Etapa

                                </label>

                                <select name="etapa"
                                        id="etapa"
                                        class="form-select">

                                    <option value="">
                                        Todas
                                    </option>

                                    @foreach($etapas as $etapa)

                                        <option value="{{ $etapa }}"
                                            {{ request('etapa') == $etapa ? 'selected' : '' }}>

                                            {{ $etapa }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            {{-- CONDICIÓN --}}
                            <div class="col-md-3">

                                <label for="condicion"
                                       class="form-label fw-bold">

                                    Condición reproductiva

                                </label>

                                <select name="condicion"
                                        id="condicion"
                                        class="form-select">

                                    <option value="">
                                        Todas
                                    </option>

                                    @foreach($condiciones as $condicion)

                                        <option value="{{ $condicion }}"
                                            {{ request('condicion') == $condicion ? 'selected' : '' }}>

                                            {{ $condicion }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>


                        {{-- BOTONES --}}
                        <div class="mt-4">

                            <button type="submit"
                                    class="btn btn-success">

                                <i class="bi bi-search"></i>

                                Filtrar

                            </button>


                            <a href="{{ route('reportes.alimentacion') }}"
                               class="btn btn-secondary">

                                <i class="bi bi-arrow-clockwise"></i>

                                Limpiar filtros

                            </a>

                        </div>

                    </form>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- RESUMEN --}}
            {{-- ========================================================= --}}

            <div class="row mb-4">


                {{-- TOTAL --}}
                <div class="col-md-4">

                    <div class="card bg-success text-white shadow">

                        <div class="card-body">

                            <h6>

                                Animales en alimentación

                            </h6>

                            <h2>

                                {{ $totalAnimales }}

                            </h2>

                        </div>

                    </div>

                </div>


                {{-- AUTOMÁTICAS --}}
                <div class="col-md-4">

                    <div class="card bg-primary text-white shadow">

                        <div class="card-body">

                            <h6>

                                Raciones automáticas

                            </h6>

                            <h2>

                                {{ $totalAutomaticas }}

                            </h2>

                        </div>

                    </div>

                </div>


                {{-- AJUSTADAS --}}
                <div class="col-md-4">

                    <div class="card bg-warning text-dark shadow">

                        <div class="card-body">

                            <h6>

                                Raciones ajustadas

                            </h6>

                            <h2>

                                {{ $totalAjustadas }}

                            </h2>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- BOTONES --}}
            {{-- ========================================================= --}}

            <div class="mb-3 d-flex justify-content-between align-items-center">


                {{-- REGRESAR --}}
                <a href="{{ route('reportes.index') }}"
                   class="btn btn-secondary">

                    <i class="bi bi-arrow-left"></i>

                    Volver a Reportes

                </a>


                {{-- PDF --}}
                <a href="{{ route('reportes.alimentacion.pdf', request()->query()) }}"
                   class="btn btn-danger">

                    <i class="bi bi-file-earmark-pdf"></i>

                    Exportar PDF

                </a>

            </div>


            {{-- ========================================================= --}}
            {{-- MENSAJE FILTRO --}}
            {{-- ========================================================= --}}

            @if(request()->hasAny([
                'animal_id',
                'sexo',
                'etapa',
                'condicion'
            ]))

                <div class="alert alert-info">

                    <i class="bi bi-info-circle"></i>

                    <strong>Filtro aplicado:</strong>

                    {{ $totalAnimales }}

                    animal(es) encontrado(s).

                </div>

            @endif


            {{-- ========================================================= --}}
            {{-- TABLA --}}
            {{-- ========================================================= --}}

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-success">

                        <tr>

                            <th>
                                #
                            </th>

                            <th>
                                Animal
                            </th>

                            <th>
                                Sexo
                            </th>

                            <th>
                                Etapa
                            </th>

                            <th>
                                Peso
                            </th>

                            <th>
                                Condición
                            </th>

                            <th>
                                Días Gestación
                            </th>

                            <th>
                                Ración
                            </th>

                            <th>
                                Cantidad a suministrar
                            </th>

                            <th>
                                Tipo
                            </th>

                            <th>
                                Observación
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                    @forelse($animales as $animal)

                        <tr>

                            {{-- # --}}
                            <td>

                                {{ $loop->iteration }}

                            </td>


                            {{-- ANIMAL --}}
                            <td>

                                <strong>

                                    {{ $animal->codigo }}

                                </strong>

                            </td>


                            {{-- SEXO --}}
                            <td>

                                {{ $animal->sexo }}

                            </td>


                            {{-- ETAPA --}}
                            <td>

                                {{ $animal->etapa }}

                            </td>


                            {{-- PESO --}}
                            <td>

                                {{ number_format(
                                    $animal->peso_actual,
                                    2
                                ) }}

                                Kg

                            </td>


                            {{-- CONDICIÓN --}}
                            <td>

                                @if($animal->condicion_reproductiva)

                                    <span class="badge bg-info text-dark">

                                        {{ $animal->condicion_reproductiva }}

                                    </span>

                                @else

                                    <span class="text-muted">

                                        No aplica

                                    </span>

                                @endif

                            </td>


                            {{-- DÍAS DE GESTACIÓN --}}
                            <td>

                                @if($animal->dias_gestacion)

                                    {{ $animal->dias_gestacion }}

                                    días

                                @else

                                    —

                                @endif

                            </td>


                            {{-- RACIÓN --}}
                            <td>

                                @if($animal->racion_recomendada)

                                    @php

                                        $nombreRacion =
                                            $animal->racion_recomendada->tipo_alimento
                                            ?? $animal->racion_recomendada->alimento
                                            ?? $animal->racion_recomendada->nombre
                                            ?? null;

                                    @endphp

                                    {{ $nombreRacion ?? 'Según etapa y condición' }}

                                @else

                                    <span class="text-danger">

                                        Sin ración configurada

                                    </span>

                                @endif

                            </td>


                            {{-- CANTIDAD --}}
                            <td>

                                @if($animal->cantidad_mostrar !== null)

                                    <strong>

                                        {{ number_format(
                                            $animal->cantidad_mostrar,
                                            2
                                        ) }}

                                        Kg

                                    </strong>

                                @else

                                    <span class="text-danger">

                                        No definida

                                    </span>

                                @endif

                            </td>


                            {{-- TIPO --}}
                            <td>

                                @if($animal->tipo_cantidad === 'Ajustada')

                                    <span class="badge bg-warning text-dark">

                                        Ajustada

                                    </span>

                                @else

                                    <span class="badge bg-primary">

                                        Automática

                                    </span>

                                @endif

                            </td>


                            {{-- OBSERVACIÓN --}}
                            <td>

                                @if($animal->observacion_reporte)

                                    {{ $animal->observacion_reporte }}

                                @else

                                    <span class="text-muted">

                                        —

                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="11"
                                class="text-center py-4">

                                <i class="bi bi-info-circle"></i>

                                No existen animales que coincidan
                                con los filtros seleccionados.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>


            {{-- ========================================================= --}}
            {{-- NOTA --}}
            {{-- ========================================================= --}}

            <div class="alert alert-secondary mt-3">

                <i class="bi bi-info-circle"></i>

                <strong>Nota:</strong>

                La cantidad mostrada corresponde a la ración automática
                calculada por el sistema. Si el animal tiene un ajuste
                registrado, se muestra la cantidad ajustada.

            </div>


        </div>

    </div>

</div>

@endsection