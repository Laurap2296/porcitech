@extends('layouts.app')

@section('title', 'Alimentación')

@section('content')

<div class="container-fluid">

    {{-- MENSAJES --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle"></i>
            {{ session('error') }}
        </div>
    @endif


    <div class="card shadow">

        {{-- ENCABEZADO --}}
        <div class="card-header bg-success text-white">

            <h4 class="mb-0">
                <i class="bi bi-egg-fried"></i>
                Control de Alimentación
            </h4>

        </div>


        <div class="card-body">

            {{-- INFORMACIÓN --}}
            <div class="alert alert-info">

                <i class="bi bi-info-circle"></i>

                La información de <strong>peso</strong> y
                <strong>etapa</strong> se obtiene directamente
                del módulo <strong>Animales</strong>.

                La <strong>ración recomendada</strong> y la
                <strong>cantidad diaria</strong> se calculan
                automáticamente según la etapa, sexo, peso y
                condición reproductiva.

                <br>

                <small>
                    <strong>Nota:</strong>
                    Si es necesario modificar temporalmente la
                    cantidad de alimento, puede realizar un
                    <strong>ajuste</strong> y registrar el motivo.
                </small>

            </div>


            {{-- TABLA --}}
            <div class="alimentacion-tabla">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-success">

                        <tr>

                            <th>#</th>
                            <th>Animal</th>
                            <th>Sexo</th>
                            <th>Etapa</th>
                            <th>Peso actual</th>
                            <th>Condición reproductiva</th>
                            <th>Ración recomendada</th>
                            <th>Cantidad diaria</th>
                            <th>Estado</th>
                            <th class="columna-acciones">Acciones</th>

                        </tr>

                    </thead>


                    <tbody>

                    @forelse($animales as $animal)

                        @php

                            $inactivo = in_array(
                                $animal->estado,
                                ['Vendido', 'Muerto']
                            );

                        @endphp


                        <tr
                            @if($inactivo)
                                class="table-secondary text-muted"
                            @endif
                        >

                            {{-- # --}}
                            <td>
                                {{ $animales->firstItem() + $loop->index }}
                            </td>


                            {{-- ANIMAL --}}
                            <td>

                                <strong>
                                    {{ $animal->codigo }}
                                </strong>

                                @if($inactivo)

                                    <br>

                                    <small>
                                        Registro histórico
                                    </small>

                                @endif

                            </td>


                            {{-- SEXO --}}
                            <td>
                                {{ $animal->sexo }}
                            </td>


                            {{-- ETAPA --}}
                            <td>

                                <span class="badge

                                    @if($animal->etapa == 'Lechon')
                                        bg-warning text-dark

                                    @elseif($animal->etapa == 'Levante')
                                        bg-primary

                                    @elseif($animal->etapa == 'Ceba')
                                        bg-danger

                                    @else
                                        bg-success
                                    @endif
                                ">

                                    {{ $animal->etapa }}

                                </span>

                            </td>


                            {{-- PESO --}}
                            <td>

                                @if(
                                    $animal->peso_actual === null ||
                                    $animal->peso_actual <= 0
                                )

                                    <span class="text-warning">
                                        Pendiente
                                    </span>

                                @else

                                    <strong>
                                        {{ number_format(
                                            $animal->peso_actual,
                                            2
                                        ) }}
                                        kg
                                    </strong>

                                @endif

                            </td>


                            {{-- CONDICIÓN REPRODUCTIVA --}}
                            <td>

                                @if($animal->condicion_reproductiva)

                                    @if(
                                        $animal->condicion_reproductiva
                                        == 'Gestante'
                                    )

                                        <span class="badge bg-success">
                                            Gestante
                                        </span>

                                        @if($animal->dias_gestacion)

                                            <br>

                                            <small>
                                                {{ $animal->dias_gestacion }}
                                                días de gestación
                                            </small>

                                        @endif


                                    @elseif(
                                        $animal->condicion_reproductiva
                                        == 'Lactante'
                                    )

                                        <span class="badge bg-warning text-dark">
                                            Lactante
                                        </span>


                                    @elseif(
                                        $animal->condicion_reproductiva
                                        == 'Vacia'
                                    )

                                        <span class="badge bg-secondary">
                                            Vacía
                                        </span>


                                    @elseif(
                                        $animal->condicion_reproductiva
                                        == 'Servicio'
                                    )

                                        <span class="badge bg-info text-dark">
                                            En servicio
                                        </span>


                                    @else

                                        <span class="badge bg-secondary">
                                            {{ $animal->condicion_reproductiva }}
                                        </span>

                                    @endif

                                @else

                                    <span class="text-muted">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- RACIÓN RECOMENDADA --}}
                            <td>

                                @if($inactivo)

                                    <span class="text-muted">
                                        No disponible
                                    </span>

                                @elseif(
                                    $animal->peso_actual === null ||
                                    $animal->peso_actual <= 0
                                )

                                    <span class="text-warning">
                                        Pendiente de peso
                                    </span>

                                @elseif($animal->racion_recomendada)

                                    <strong>
                                        {{ $animal->racion_recomendada->tipo_alimento }}
                                    </strong>

                                    <br>

                                    <small>
                                        {{ $animal->racion_recomendada->nombre }}
                                    </small>

                                @else

                                    <span class="text-danger">
                                        Sin ración definida
                                    </span>

                                @endif

                            </td>


                            {{-- CANTIDAD DIARIA --}}
                            <td>

                                @if($inactivo)

                                    <span class="text-muted">
                                        No disponible
                                    </span>

                                @elseif(
                                    $animal->peso_actual === null ||
                                    $animal->peso_actual <= 0
                                )

                                    <span class="text-warning">
                                        Pendiente de peso
                                    </span>

                                @elseif($animal->cantidad_mostrar !== null)

                                    <strong>
                                        {{ number_format(
                                            $animal->cantidad_mostrar,
                                            2
                                        ) }}
                                        kg/día
                                    </strong>

                                    @if($animal->tipo_cantidad === 'Ajustada')

                                        <br>

                                        <span class="badge bg-warning text-dark">
                                            Ajustada
                                        </span>

                                        @if($animal->observacion_alimentacion)

                                            <br>

                                            <small
                                                title="{{ $animal->observacion_alimentacion }}"
                                            >
                                                {{ \Illuminate\Support\Str::limit(
                                                    $animal->observacion_alimentacion,
                                                    35
                                                ) }}
                                            </small>

                                        @endif

                                    @else

                                        <br>

                                        <small class="text-muted">
                                            Automática
                                        </small>

                                    @endif

                                @else

                                    <span class="text-warning">
                                        Pendiente
                                    </span>

                                @endif

                            </td>


                            {{-- ESTADO --}}
                            <td>

                                @if($animal->estado == 'Activo')

                                    <span class="badge bg-success">
                                        Activo
                                    </span>

                                @elseif($animal->estado == 'Vendido')

                                    <span class="badge bg-secondary">
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


                            {{-- ACCIONES --}}
                            <td class="columna-acciones">

                                @if(!$inactivo)

                                    <a
                                        href="{{ route(
                                            'alimentaciones.ajuste.edit',
                                            $animal->id
                                        ) }}"
                                        class="btn btn-warning btn-sm"
                                    >

                                        <i class="bi bi-pencil-square"></i>

                                        Ajustar

                                    </a>

                                @else

                                    <span class="text-muted">
                                        No disponible
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

                                No existen animales registrados.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>


            {{-- PAGINACIÓN --}}
            @if($animales->hasPages())

                <div class="d-flex justify-content-center mt-4">

                    {{ $animales->links() }}

                </div>

            @endif

        </div>

    </div>

</div>


<style>

    .alimentacion-tabla {
        width: 100%;
        overflow-x: auto;
        overflow-y: hidden;
        padding-bottom: 10px;
    }

    .alimentacion-tabla table {
        min-width: 1400px;
        margin-bottom: 0;
    }

    .alimentacion-tabla th,
    .alimentacion-tabla td {
        white-space: nowrap;
    }


    /*
    |--------------------------------------------------------------------------
    | COLUMNA ACCIONES SIEMPRE VISIBLE
    |--------------------------------------------------------------------------
    */

    .alimentacion-tabla th.columna-acciones,
    .alimentacion-tabla td.columna-acciones {

        position: sticky;

        right: 0;

        z-index: 5;

        background: white;

        min-width: 110px;

        text-align: center;

    }

    .alimentacion-tabla th.columna-acciones {

        background: #198754;

        color: white;

    }

    .alimentacion-tabla td.columna-acciones {

        box-shadow: -4px 0 8px rgba(0,0,0,0.08);

    }


    /*
    |--------------------------------------------------------------------------
    | BARRA HORIZONTAL
    |--------------------------------------------------------------------------
    */

    .alimentacion-tabla::-webkit-scrollbar {

        height: 12px;

    }

    .alimentacion-tabla::-webkit-scrollbar-track {

        background: #e9ecef;

        border-radius: 10px;

    }

    .alimentacion-tabla::-webkit-scrollbar-thumb {

        background: #198754;

        border-radius: 10px;

    }

    .alimentacion-tabla::-webkit-scrollbar-thumb:hover {

        background: #146c43;

    }


    /*
    |--------------------------------------------------------------------------
    | PAGINACIÓN
    |--------------------------------------------------------------------------
    */

    .pagination {

        margin-bottom: 0;

    }

</style>

@endsection