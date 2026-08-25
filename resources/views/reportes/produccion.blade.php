@extends('layouts.app')

@section('title', 'Reporte de Producción')

@section('content')

<div class="container-fluid">

    <div class="card shadow mb-4">

        {{-- ==========================================================
             ENCABEZADO
        =========================================================== --}}
        <div class="card-header bg-success text-white">

            <div class="d-flex justify-content-between align-items-center">

                <h4 class="mb-0">
                    <i class="bi bi-bar-chart-line"></i>
                    Reporte de Producción
                </h4>

                <a href="{{ route('reportes.index') }}"
                   class="btn btn-light">

                    <i class="bi bi-arrow-left"></i>
                    Volver a Reportes

                </a>

            </div>

        </div>


        <div class="card-body">

            {{-- ==========================================================
                 RESUMEN
            =========================================================== --}}
            <div class="row mb-4">

                {{-- TOTAL --}}
                <div class="col-md-4">

                    <div class="card bg-success text-white shadow">

                        <div class="card-body">

                            <h6>
                                Registros de Producción
                            </h6>

                            <h2>
                                {{ $producciones->count() }}
                            </h2>

                        </div>

                    </div>

                </div>


                {{-- ANIMALES --}}
                <div class="col-md-4">

                    <div class="card bg-primary text-white shadow">

                        <div class="card-body">

                            <h6>
                                Animales Evaluados
                            </h6>

                            <h2>
                                {{ $producciones
                                    ->pluck('animal_id')
                                    ->unique()
                                    ->count()
                                }}
                            </h2>

                        </div>

                    </div>

                </div>


                {{-- PESO PROMEDIO --}}
                <div class="col-md-4">

                    <div class="card bg-warning text-dark shadow">

                        <div class="card-body">

                            <h6>
                                Peso Promedio Vivo
                            </h6>

                            <h4>

                                {{ number_format(
                                    $producciones->avg('peso_vivo'),
                                    2
                                ) }}

                                Kg

                            </h4>

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
                          action="{{ route('reportes.produccion') }}">

                        <div class="row">

                            {{-- FECHA DESDE --}}
                            <div class="col-md-3 mb-3">

                                <label class="form-label fw-bold">
                                    Fecha desde
                                </label>

                                <input
                                    type="date"
                                    name="fecha_desde"
                                    class="form-control"
                                    value="{{ request('fecha_desde') }}"
                                >

                            </div>


                            {{-- FECHA HASTA --}}
                            <div class="col-md-3 mb-3">

                                <label class="form-label fw-bold">
                                    Fecha hasta
                                </label>

                                <input
                                    type="date"
                                    name="fecha_hasta"
                                    class="form-control"
                                    value="{{ request('fecha_hasta') }}"
                                >

                            </div>


                            {{-- TIPO --}}
                            <div class="col-md-3 mb-3">

                                <label class="form-label fw-bold">
                                    Tipo de registro
                                </label>

                                <select
                                    name="tipo_registro"
                                    class="form-select"
                                >

                                    <option value="">
                                        Todos
                                    </option>

                                    <option
                                        value="mensual"
                                        {{ request('tipo_registro') == 'mensual'
                                            ? 'selected'
                                            : ''
                                        }}
                                    >
                                        Mensual
                                    </option>

                                    <option
                                        value="sacrificio"
                                        {{ request('tipo_registro') == 'sacrificio'
                                            ? 'selected'
                                            : ''
                                        }}
                                    >
                                        Sacrificio
                                    </option>

                                </select>

                            </div>


                            {{-- ANIMAL --}}
                            <div class="col-md-3 mb-3">

                                <label class="form-label fw-bold">
                                    Animal
                                </label>

                                <select
                                    name="animal_id"
                                    class="form-select"
                                >

                                    <option value="">
                                        Todos
                                    </option>

                                    @foreach($animales as $animal)

                                        <option
                                            value="{{ $animal->id }}"
                                            {{ request('animal_id') == $animal->id
                                                ? 'selected'
                                                : ''
                                            }}
                                        >

                                            {{ $animal->codigo }}

                                            @if($animal->raza)
                                                - {{ $animal->raza }}
                                            @endif

                                            @if($animal->estado)
                                                ({{ $animal->estado }})
                                            @endif

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>


                        {{-- BOTONES --}}
                        <div class="d-flex gap-2">

                            <button
                                type="submit"
                                class="btn btn-success"
                            >

                                <i class="bi bi-search"></i>
                                Aplicar filtros

                            </button>


                            <a
                                href="{{ route('reportes.produccion') }}"
                                class="btn btn-secondary"
                            >

                                <i class="bi bi-x-circle"></i>
                                Limpiar filtros

                            </a>

                        </div>

                    </form>

                </div>

            </div>


            {{-- ==========================================================
                 FILTROS APLICADOS
            =========================================================== --}}
            @if(
                request('fecha_desde') ||
                request('fecha_hasta') ||
                request('tipo_registro') ||
                request('animal_id')
            )

                <div class="alert alert-info">

                    <i class="bi bi-info-circle"></i>

                    <strong>
                        Filtros aplicados:
                    </strong>


                    @if(request('fecha_desde'))

                        Desde:

                        <strong>

                            {{ \Carbon\Carbon::parse(
                                request('fecha_desde')
                            )->format('d/m/Y') }}

                        </strong>

                    @endif


                    @if(request('fecha_hasta'))

                        @if(request('fecha_desde'))
                            |
                        @endif

                        Hasta:

                        <strong>

                            {{ \Carbon\Carbon::parse(
                                request('fecha_hasta')
                            )->format('d/m/Y') }}

                        </strong>

                    @endif


                    @if(request('tipo_registro'))

                        |

                        Tipo:

                        <strong>

                            {{ ucfirst(
                                request('tipo_registro')
                            ) }}

                        </strong>

                    @endif


                    @if(request('animal_id'))

                        |

                        Animal:

                        <strong>

                            @php

                                $animalFiltro =
                                    $animales->firstWhere(
                                        'id',
                                        request('animal_id')
                                    );

                            @endphp

                            {{ $animalFiltro
                                ? $animalFiltro->codigo
                                : 'No encontrado'
                            }}

                        </strong>

                    @endif

                </div>

            @endif


            {{-- ==========================================================
                 EXPORTACIÓN
            =========================================================== --}}
            <div class="d-flex justify-content-between align-items-center mb-3">

                {{-- VOLVER --}}
                <a
                    href="{{ route('reportes.index') }}"
                    class="btn btn-secondary"
                >

                    <i class="bi bi-arrow-left"></i>
                    Volver a reportes

                </a>


                {{-- PDF --}}
                <a
                    href="{{ route(
                        'reportes.produccion.pdf',
                        request()->query()
                    ) }}"
                    class="btn btn-danger"
                >

                    <i class="bi bi-file-earmark-pdf"></i>
                    Exportar PDF

                </a>

            </div>


            {{-- ==========================================================
                 TABLA
            =========================================================== --}}
            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="table-success">

                        <tr>

                            <th>
                                #
                            </th>

                            <th>
                                Animal
                            </th>

                            <th>
                                Estado
                            </th>

                            <th>
                                Fecha
                            </th>

                            <th>
                                Tipo Registro
                            </th>

                            <th>
                                Peso Vivo
                            </th>

                            <th>
                                Peso Canal
                            </th>

                            <th>
                                Rendimiento
                            </th>

                            <th>
                                Observaciones
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($producciones as $produccion)

                            <tr>

                                {{-- ==================================================
                                     #
                                =================================================== --}}
                                <td>

                                    {{ $loop->iteration }}

                                </td>


                                {{-- ==================================================
                                     ANIMAL
                                =================================================== --}}
                                <td>

                                    @if($produccion->animal)

                                        <strong>

                                            {{ $produccion->animal->codigo }}

                                        </strong>

                                    @else

                                        Sin animal

                                    @endif

                                </td>


                                {{-- ==================================================
                                     ESTADO
                                =================================================== --}}
                                <td>

                                    @if($produccion->animal)

                                        @if(
                                            $produccion->animal->estado === 'Muerto'
                                        )

                                            <span class="badge bg-dark">
                                                Muerto
                                            </span>

                                        @elseif(
                                            $produccion->animal->estado === 'Vendido'
                                        )

                                            <span class="badge bg-danger">
                                                Vendido
                                            </span>

                                        @elseif(
                                            $produccion->animal->estado === 'Activo'
                                        )

                                            <span class="badge bg-success">
                                                Activo
                                            </span>

                                        @else

                                            <span class="badge bg-secondary">

                                                {{ $produccion->animal->estado }}

                                            </span>

                                        @endif

                                    @else

                                        <span class="badge bg-secondary">
                                            Sin animal
                                        </span>

                                    @endif

                                </td>


                                {{-- ==================================================
                                     FECHA
                                =================================================== --}}
                                <td>

                                    {{ \Carbon\Carbon::parse(
                                        $produccion->fecha_pesaje
                                    )->format('d/m/Y') }}

                                </td>


                                {{-- ==================================================
                                     TIPO
                                =================================================== --}}
                                <td>

                                    @if(
                                        $produccion->tipo_registro ===
                                        'sacrificio'
                                    )

                                        <span class="badge bg-danger">
                                            Sacrificio
                                        </span>

                                    @else

                                        <span class="badge bg-primary">
                                            Mensual
                                        </span>

                                    @endif

                                </td>


                                {{-- ==================================================
                                     PESO VIVO
                                =================================================== --}}
                                <td>

                                    @if($produccion->peso_vivo !== null)

                                        {{ number_format(
                                            $produccion->peso_vivo,
                                            2
                                        ) }}

                                        Kg

                                    @else

                                        N/A

                                    @endif

                                </td>


                                {{-- ==================================================
                                     PESO CANAL
                                =================================================== --}}
                                <td>

                                    @if(
                                        $produccion->peso_canal !== null
                                    )

                                        <strong>

                                            {{ number_format(
                                                $produccion->peso_canal,
                                                2
                                            ) }}

                                        </strong>

                                        Kg

                                    @else

                                        N/A

                                    @endif

                                </td>


                                {{-- ==================================================
                                     RENDIMIENTO
                                     SE CALCULA DIRECTAMENTE
                                =================================================== --}}
                                <td>

                                    @if(
                                        $produccion->tipo_registro === 'sacrificio' &&
                                        $produccion->peso_vivo !== null &&
                                        $produccion->peso_canal !== null &&
                                        $produccion->peso_vivo > 0
                                    )

                                        @php

                                            $rendimiento =
                                                ($produccion->peso_canal /
                                                $produccion->peso_vivo) * 100;

                                        @endphp

                                        <strong class="text-success">

                                            {{ number_format(
                                                $rendimiento,
                                                2
                                            ) }}

                                            %

                                        </strong>

                                    @else

                                        N/A

                                    @endif

                                </td>


                                {{-- ==================================================
                                     OBSERVACIONES
                                =================================================== --}}
                                <td>

                                    {{ $produccion->observaciones
                                        ?? 'Sin observaciones'
                                    }}

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="9"
                                    class="text-center py-4"
                                >

                                    <i
                                        class="bi bi-search"
                                        style="font-size:35px;"
                                    ></i>

                                    <p class="mt-2 mb-0">

                                        No existen registros
                                        con los filtros seleccionados.

                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- ==========================================================
                 TOTAL
            =========================================================== --}}
            <div class="text-end mt-3">

                <strong>

                    Registros mostrados:

                    {{ $producciones->count() }}

                </strong>

            </div>

        </div>

    </div>

</div>

@endsection