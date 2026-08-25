@extends('layouts.app')

@section('title', 'Reporte de Animales')

@section('content')

<div class="container-fluid">

    <div class="card shadow mb-4">

        {{-- ENCABEZADO --}}
        <div class="card-header bg-success text-white">

            <div class="d-flex justify-content-between align-items-center">

                <h4 class="mb-0">
                    <i class="bi bi-heart-pulse"></i>
                    Reporte de Animales
                </h4>

                {{-- BOTÓN VOLVER --}}
                <a href="{{ route('reportes.index') }}"
                   class="btn btn-light">

                    <i class="bi bi-arrow-left"></i>
                    Volver

                </a>

            </div>

        </div>


        <div class="card-body">


            {{-- ==========================================================
                 RESUMEN
            =========================================================== --}}

            <div class="row mb-4">

                {{-- TOTAL --}}
                <div class="col-md-3">

                    <div class="card bg-success text-white shadow">

                        <div class="card-body">

                            <h6>Total Animales</h6>

                            <h2>
                                {{ $animales->count() }}
                            </h2>

                        </div>

                    </div>

                </div>


                {{-- ACTIVOS --}}
                <div class="col-md-3">

                    <div class="card bg-primary text-white shadow">

                        <div class="card-body">

                            <h6>Activos</h6>

                            <h2>
                                {{ $animales->where('estado', 'Activo')->count() }}
                            </h2>

                        </div>

                    </div>

                </div>


                {{-- REPRODUCTORES --}}
                <div class="col-md-3">

                    <div class="card bg-warning text-dark shadow">

                        <div class="card-body">

                            <h6>Reproductores</h6>

                            <h2>
                                {{ $animales->where('etapa', 'Reproductor')->count() }}
                            </h2>

                        </div>

                    </div>

                </div>


                {{-- VENDIDOS --}}
                <div class="col-md-3">

                    <div class="card bg-danger text-white shadow">

                        <div class="card-body">

                            <h6>Vendidos</h6>

                            <h2>
                                {{ $animales->where('estado', 'Vendido')->count() }}
                            </h2>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ==========================================================
                 FILTROS
            =========================================================== --}}

            <div class="card shadow-sm border-success mb-4">

                <div class="card-header bg-light">

                    <h5 class="mb-0 text-success">

                        <i class="bi bi-funnel"></i>

                        Filtrar reporte

                    </h5>

                </div>


                <div class="card-body">

                    <form method="GET"
                          action="{{ route('reportes.animales') }}">

                        <div class="row">


                            {{-- ESTADO --}}
                            <div class="col-md-4 mb-3">

                                <label class="form-label fw-bold">
                                    Estado del animal
                                </label>

                                <select name="estado"
                                        class="form-select">

                                    <option value="">
                                        Todos
                                    </option>

                                    <option value="Activo"
                                        {{ request('estado') == 'Activo' ? 'selected' : '' }}>

                                        Activos

                                    </option>

                                    <option value="Vendido"
                                        {{ request('estado') == 'Vendido' ? 'selected' : '' }}>

                                        Vendidos

                                    </option>

                                    <option value="Muerto"
                                        {{ request('estado') == 'Muerto' ? 'selected' : '' }}>

                                        Muertos

                                    </option>

                                </select>

                            </div>


                            {{-- ETAPA --}}
                            <div class="col-md-4 mb-3">

                                <label class="form-label fw-bold">
                                    Etapa
                                </label>

                                <select name="etapa"
                                        class="form-select">

                                    <option value="">
                                        Todas
                                    </option>

                                    <option value="Lechon"
                                        {{ request('etapa') == 'Lechon' ? 'selected' : '' }}>

                                        Lechón

                                    </option>

                                    <option value="Levante"
                                        {{ request('etapa') == 'Levante' ? 'selected' : '' }}>

                                        Levante

                                    </option>

                                    <option value="Ceba"
                                        {{ request('etapa') == 'Ceba' ? 'selected' : '' }}>

                                        Ceba

                                    </option>

                                    <option value="Reproductor"
                                        {{ request('etapa') == 'Reproductor' ? 'selected' : '' }}>

                                        Reproductor

                                    </option>

                                </select>

                            </div>


                            {{-- SEXO --}}
                            <div class="col-md-4 mb-3">

                                <label class="form-label fw-bold">
                                    Sexo
                                </label>

                                <select name="sexo"
                                        class="form-select">

                                    <option value="">
                                        Todos
                                    </option>

                                    <option value="Macho"
                                        {{ request('sexo') == 'Macho' ? 'selected' : '' }}>

                                        Machos

                                    </option>

                                    <option value="Hembra"
                                        {{ request('sexo') == 'Hembra' ? 'selected' : '' }}>

                                        Hembras

                                    </option>

                                </select>

                            </div>

                        </div>


                        {{-- BOTONES DEL FILTRO --}}
                        <div class="d-flex gap-2">

                            <button type="submit"
                                    class="btn btn-success">

                                <i class="bi bi-search"></i>

                                Aplicar filtros

                            </button>


                            <a href="{{ route('reportes.animales') }}"
                               class="btn btn-secondary">

                                <i class="bi bi-x-circle"></i>

                                Limpiar filtros

                            </a>

                        </div>

                    </form>

                </div>

            </div>


            {{-- ==========================================================
                 FILTRO ACTUAL
            =========================================================== --}}

            @if(request('estado') || request('etapa') || request('sexo'))

                <div class="alert alert-info">

                    <i class="bi bi-info-circle"></i>

                    <strong>Filtros aplicados:</strong>

                    @if(request('estado'))

                        Estado:
                        <strong>{{ request('estado') }}</strong>

                    @endif


                    @if(request('etapa'))

                        @if(request('estado'))
                            |
                        @endif

                        Etapa:
                        <strong>{{ request('etapa') }}</strong>

                    @endif


                    @if(request('sexo'))

                        @if(request('estado') || request('etapa'))
                            |
                        @endif

                        Sexo:
                        <strong>{{ request('sexo') }}</strong>

                    @endif

                </div>

            @endif


            {{-- ==========================================================
                 BOTONES EXPORTACIÓN
            =========================================================== --}}

            <div class="d-flex justify-content-between align-items-center mb-3">


                {{-- VOLVER --}}
                <a href="{{ route('reportes.index') }}"
                   class="btn btn-secondary">

                    <i class="bi bi-arrow-left"></i>

                    Volver a reportes

                </a>


                <div>

                    {{-- PDF --}}
                    <a href="{{ route('reportes.animales.pdf', request()->query()) }}"
                       class="btn btn-danger">

                        <i class="bi bi-file-earmark-pdf"></i>

                        Exportar PDF

                    </a>


                    

                    

                </div>

            </div>


            {{-- ==========================================================
                 TABLA
            =========================================================== --}}

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="table-success">

                        <tr>

                            <th>Código</th>

                            <th>Raza</th>

                            <th>Sexo</th>

                            <th>Etapa</th>

                            <th>Peso Actual</th>

                            <th>Origen</th>

                            <th>Estado</th>

                            <th>Granja</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($animales as $animal)

                            <tr>

                                {{-- CÓDIGO --}}
                                <td>
                                    {{ $animal->codigo }}
                                </td>


                                {{-- RAZA --}}
                                <td>
                                    {{ $animal->raza }}
                                </td>


                                {{-- SEXO --}}
                                <td>
                                    {{ $animal->sexo }}
                                </td>


                                {{-- ETAPA --}}
                                <td>

                                    @if($animal->etapa == 'Reproductor')

                                        <span class="badge bg-success">
                                            {{ $animal->etapa }}
                                        </span>

                                    @elseif($animal->etapa == 'Ceba')

                                        <span class="badge bg-warning text-dark">
                                            {{ $animal->etapa }}
                                        </span>

                                    @elseif($animal->etapa == 'Levante')

                                        <span class="badge bg-primary">
                                            {{ $animal->etapa }}
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            {{ $animal->etapa }}
                                        </span>

                                    @endif

                                </td>


                                {{-- PESO --}}
                                <td>

                                    {{ number_format($animal->peso_actual, 2) }}
                                    Kg

                                </td>


                                {{-- ORIGEN --}}
                                <td>
                                    {{ $animal->origen }}
                                </td>


                                {{-- ESTADO --}}
                                <td>

                                    @if($animal->estado == 'Activo')

                                        <span class="badge bg-success">
                                            Activo
                                        </span>

                                    @elseif($animal->estado == 'Vendido')

                                        <span class="badge bg-danger">
                                            Vendido
                                        </span>

                                    @elseif($animal->estado == 'Muerto')

                                        <span class="badge bg-dark">
                                            Muerto
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            {{ $animal->estado }}
                                        </span>

                                    @endif

                                </td>


                                {{-- GRANJA --}}
                                <td>

                                    {{ $animal->granja->nombre ?? 'Sin granja' }}

                                </td>

                            </tr>


                        @empty

                            <tr>

                                <td colspan="8"
                                    class="text-center py-4">

                                    <i class="bi bi-search"
                                       style="font-size: 35px;">
                                    </i>

                                    <p class="mt-2 mb-0">

                                        No existen animales
                                        con los filtros seleccionados.

                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- TOTAL MOSTRADO --}}
            <div class="text-end mt-3">

                <strong>

                    Registros mostrados:
                    {{ $animales->count() }}

                </strong>

            </div>


        </div>

    </div>

</div>

@endsection