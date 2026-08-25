@extends('layouts.app')

@section('content')

<div class="container-fluid">

    {{-- ========================================================= --}}
    {{-- ENCABEZADO --}}
    {{-- ========================================================= --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="mb-1">
                🐖 Historia Clínica y Productiva
            </h2>

            <p class="text-muted mb-0">
                Historial completo del animal
            </p>
        </div>

        <div class="d-flex gap-2">

            <a href="{{ route('animales.edit', $animale->id) }}"
               class="btn btn-warning btn-sm"
               title="Editar animal">
                ✏️
            </a>

            <a href="{{ route('animales.index') }}"
               class="btn btn-secondary btn-sm"
               title="Volver">
                ←
            </a>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- INFORMACIÓN DEL ANIMAL --}}
    {{-- ========================================================= --}}

    <div class="card shadow-sm mb-4">

        <div class="card-header bg-success text-white">

            <h4 class="mb-0">

                🐖 Animal {{ $animale->codigo }}

                @if($animale->raza)
                    | {{ $animale->raza }}
                @endif

                @if($animale->etapa)
                    | {{ $animale->etapa }}
                @endif

            </h4>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-3 mb-3">
                    <strong>Código</strong>
                    <div>{{ $animale->codigo }}</div>
                </div>

                <div class="col-md-3 mb-3">
                    <strong>Raza</strong>
                    <div>{{ $animale->raza ?? '---' }}</div>
                </div>

                <div class="col-md-3 mb-3">
                    <strong>Sexo</strong>
                    <div>{{ $animale->sexo ?? '---' }}</div>
                </div>

                <div class="col-md-3 mb-3">
                    <strong>Estado</strong>
                    <div>

                        @if($animale->estado === 'Activo')

                            <span class="badge bg-success">
                                Activo
                            </span>

                        @elseif($animale->estado === 'Vendido')

                            <span class="badge bg-primary">
                                Vendido
                            </span>

                        @elseif($animale->estado === 'Muerto')

                            <span class="badge bg-danger">
                                Muerto
                            </span>

                        @else

                            <span class="badge bg-secondary">
                                {{ $animale->estado }}
                            </span>

                        @endif

                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <strong>Fecha de nacimiento</strong>
                    <div>{{ $animale->fecha_nacimiento ?? '---' }}</div>
                </div>

                <div class="col-md-3 mb-3">
                    <strong>Peso actual</strong>
                    <div>
                        {{ $animale->peso_actual ?? '---' }} Kg
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <strong>Etapa productiva</strong>
                    <div>{{ $animale->etapa ?? '---' }}</div>
                </div>

                <div class="col-md-3 mb-3">
                    <strong>Origen</strong>
                    <div>{{ $animale->origen ?? '---' }}</div>
                </div>

                <div class="col-md-3 mb-3">
                    <strong>Fecha de ingreso</strong>
                    <div>{{ $animale->fecha_ingreso ?? '---' }}</div>
                </div>

                <div class="col-md-3 mb-3">
                    <strong>Proveedor</strong>
                    <div>{{ $animale->proveedor ?? '---' }}</div>
                </div>

                <div class="col-md-3 mb-3">
                    <strong>Granja</strong>
                    <div>
                        {{ $animale->granja->nombre ?? 'N/A' }}
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <strong>Código genético</strong>
                    <div>
                        {{ $animale->codigo_genetico ?? '---' }}
                    </div>
                </div>

            </div>

            <hr>

            <div class="row">

                <div class="col-md-6">

                    <strong>Madre</strong>

                    <div>

                        @if($madre)

                            {{ $madre->codigo }}

                            @if($madre->raza)
                                | {{ $madre->raza }}
                            @endif

                        @else

                            No registrada

                        @endif

                    </div>

                </div>

                <div class="col-md-6">

                    <strong>Padre</strong>

                    <div>

                        @if($padre)

                            {{ $padre->codigo }}

                            @if($padre->raza)
                                | {{ $padre->raza }}
                            @endif

                        @else

                            No registrado

                        @endif

                    </div>

                </div>

            </div>

            @if($animale->observaciones)

                <hr>

                <strong>Observaciones generales</strong>

                <p class="mb-0 mt-2">
                    {{ $animale->observaciones }}
                </p>

            @endif

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- RESUMEN --}}
    {{-- ========================================================= --}}

    <div class="row mb-4">

        <div class="col-md-3 mb-3">

            <div class="card shadow-sm border-success h-100">

                <div class="card-body text-center">

                    <h6 class="text-muted">
                        Registros sanitarios
                    </h6>

                    <h2 class="text-success">
                        {{ $animale->sanidades->count() }}
                    </h2>

                </div>

            </div>

        </div>


        <div class="col-md-3 mb-3">

            <div class="card shadow-sm border-primary h-100">

                <div class="card-body text-center">

                    <h6 class="text-muted">
                        Registros alimentación
                    </h6>

                    <h2 class="text-primary">
                        {{ $animale->alimentaciones->count() }}
                    </h2>

                </div>

            </div>

        </div>


        <div class="col-md-3 mb-3">

            <div class="card shadow-sm border-warning h-100">

                <div class="card-body text-center">

                    <h6 class="text-muted">
                        Registros producción
                    </h6>

                    <h2 class="text-warning">
                        {{ $animale->producciones->count() }}
                    </h2>

                </div>

            </div>

        </div>


        <div class="col-md-3 mb-3">

            <div class="card shadow-sm border-danger h-100">

                <div class="card-body text-center">

                    <h6 class="text-muted">
                        Registros reproductivos
                    </h6>

                    <h2 class="text-danger">

                        {{
                            $animale->reproduccionesHembra->count()
                            +
                            $animale->reproduccionesMacho->count()
                        }}

                    </h2>

                </div>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- HISTORIAL SANITARIO --}}
    {{-- ========================================================= --}}

    <div class="card shadow-sm mb-4">

        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">

            <strong>🩺 Historial sanitario</strong>

            <a href="{{ route('sanidades.create') }}"
               class="btn btn-light btn-sm"
               title="Nuevo registro">
                +
            </a>

        </div>

        <div class="card-body">

            @if($animale->sanidades->count() > 0)

                <div class="table-responsive">

                    <table class="table table-bordered table-striped align-middle">

                        <thead>

                            <tr>
                                <th>Fecha</th>
                                <th>Tipo</th>
                                <th>Nombre</th>
                                <th>Diagnóstico</th>
                                <th>Próxima fecha</th>
                                <th>Observaciones</th>
                                <th class="text-center">Acciones</th>
                            </tr>

                        </thead>

                        <tbody>

                        @foreach($animale->sanidades as $registro)

                            <tr>

                                <td>
                                    {{ $registro->fecha ?? '---' }}
                                </td>

                                <td>
                                    {{ $registro->tipo_registro ?? '---' }}
                                </td>

                                <td>
                                    {{ $registro->nombre ?? '---' }}
                                </td>

                                <td>
                                    {{ $registro->diagnostico ?? '---' }}
                                </td>

                                <td>
                                    {{ $registro->proxima_fecha ?? '---' }}
                                </td>

                                <td>
                                    {{ $registro->observaciones ?? '---' }}
                                </td>

                                <td class="text-center text-nowrap">

                                    <a href="{{ route('sanidades.edit', $registro->id) }}"
                                       class="btn btn-sm btn-outline-warning"
                                       title="Editar">
                                        ✏️
                                    </a>

                                    <form action="{{ route('sanidades.destroy', $registro->id) }}"
                                          method="POST"
                                          class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Eliminar"
                                                onclick="return confirm('¿Deseas eliminar este registro?')">
                                            🗑️
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="alert alert-secondary mb-0">
                    Este animal no tiene registros sanitarios.
                </div>

            @endif

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- ALIMENTACIÓN ACTUAL --}}
    {{-- ========================================================= --}}

    <div class="card shadow-sm mb-4">

        <div class="card-header bg-primary text-white">

            <strong>
                🌽 Alimentación actual
            </strong>

        </div>

        <div class="card-body">

            <p class="text-muted">
                La ración y cantidad recomendada se calculan automáticamente
                según el peso, etapa productiva, sexo y condición reproductiva.
            </p>


            <div class="row">

                <div class="col-md-3 mb-3">

                    <strong>Peso actual</strong>

                    <div>
                        {{ number_format($animale->peso_actual ?? 0, 2, ',', '.') }} Kg
                    </div>

                </div>


                <div class="col-md-3 mb-3">

                    <strong>Etapa</strong>

                    <div>
                        {{ $animale->etapa ?? '---' }}
                    </div>

                </div>


                <div class="col-md-3 mb-3">

                    <strong>Sexo</strong>

                    <div>
                        {{ $animale->sexo ?? '---' }}
                    </div>

                </div>


                <div class="col-md-3 mb-3">

                    <strong>Estado</strong>

                    <div>
                        {{ $animale->estado ?? '---' }}
                    </div>

                </div>

            </div>


            @if($animale->estado === 'Activo')

                <hr>

                <div class="row">

                    <div class="col-md-4 mb-3">

                        <strong>Ración recomendada</strong>

                        <div class="mt-1">

                            @if($racionAutomatica)

                                <span class="badge bg-success fs-6">

                                    {{ $racionAutomatica->nombre
                                        ?? $racionAutomatica->tipo_alimento
                                        ?? 'Ración calculada' }}

                                </span>

                            @else

                                <span class="text-muted">
                                    No se encontró una ración compatible.
                                </span>

                            @endif

                        </div>

                    </div>


                    <div class="col-md-4 mb-3">

                        <strong>Cantidad recomendada</strong>

                        <div class="mt-1">

                            @if($cantidadAutomatica !== null)

                                <strong>
                                    {{ number_format($cantidadAutomatica, 2, ',', '.') }}
                                    Kg/día
                                </strong>

                            @else

                                <span class="text-muted">
                                    No disponible
                                </span>

                            @endif

                        </div>

                    </div>


                    <div class="col-md-4 mb-3">

                        <strong>Condición reproductiva</strong>

                        <div class="mt-1">

                            {{ $condicionReproductiva ?? '---' }}

                            @if($diasGestacion !== null)

                                <br>

                                <small class="text-muted">
                                    {{ $diasGestacion }} días de gestación
                                </small>

                            @endif

                        </div>

                    </div>

                </div>


                @if($alimentacionAjustada)

                    <div class="alert alert-warning">

                        <strong>⚠️ Ajuste manual registrado</strong>

                        <br>

                        <strong>Cantidad ajustada:</strong>
                        {{ number_format($animale->cantidad_ajustada, 2, ',', '.') }}
                        Kg/día

                        <br>

                        <strong>Motivo:</strong>
                        {{ $animale->observacion_alimentacion ?? '---' }}

                    </div>

                @else

                    <div class="alert alert-success">

                        <strong>✓ Alimentación automática activa</strong>

                        <br>

                        Este animal utiliza la ración y cantidad calculadas
                        automáticamente por el sistema.

                    </div>

                @endif

            @else

                <div class="alert alert-secondary">

                    Este animal se encuentra
                    <strong>{{ strtolower($animale->estado) }}</strong>.
                    No se calcula alimentación automática para animales inactivos.

                </div>

            @endif


            {{-- ================================================= --}}
            {{-- REGISTROS GUARDADOS --}}
            {{-- ================================================= --}}

            <hr>

            <h6 class="mb-3">
                📋 Registros de alimentación
            </h6>


            @if($animale->alimentaciones->count() > 0)

                <div class="table-responsive">

                    <table class="table table-bordered table-striped align-middle">

                        <thead>

                            <tr>
                                <th>Fecha</th>
                                <th>Tipo de alimento</th>
                                <th>Cantidad</th>
                                <th>Observaciones</th>
                                <th class="text-center">Acciones</th>
                            </tr>

                        </thead>

                        <tbody>

                        @foreach($animale->alimentaciones as $alimentacion)

                            <tr>

                                <td>
                                    {{ $alimentacion->fecha ?? '---' }}
                                </td>

                                <td>
                                    {{ $alimentacion->tipo_alimento ?? '---' }}
                                </td>

                                <td>
                                    {{ $alimentacion->cantidad_suministrada ?? '---' }}
                                    Kg
                                </td>

                                <td>
                                    {{ $alimentacion->observaciones ?? '---' }}
                                </td>

                                <td class="text-center text-nowrap">

                                    <a href="{{ route('alimentaciones.edit', $alimentacion->id) }}"
                                       class="btn btn-sm btn-outline-warning"
                                       title="Editar">
                                        ✏️
                                    </a>

                                    <form action="{{ route('alimentaciones.destroy', $alimentacion->id) }}"
                                          method="POST"
                                          class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Eliminar"
                                                onclick="return confirm('¿Deseas eliminar este registro?')">
                                            🗑️
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="alert alert-info mb-0">

                    No existen registros históricos de alimentación guardados
                    para este animal.

                    <br>

                    <small>
                        La alimentación automática se calcula según las
                        características actuales del animal y no necesita
                        almacenarse como un registro independiente.
                    </small>

                </div>

            @endif

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- HISTORIAL DE PRODUCCIÓN --}}
    {{-- ========================================================= --}}

    <div class="card shadow-sm mb-4">

        <div class="card-header bg-warning">

            <strong>
                ⚖️ Historial de producción
            </strong>

        </div>

        <div class="card-body">

            @if($animale->producciones->count() > 0)

                <div class="table-responsive">

                    <table class="table table-bordered table-striped align-middle">

                        <thead>

                            <tr>

                                <th>Fecha</th>
                                <th>Tipo de registro</th>
                                <th>Peso vivo</th>
                                <th>Peso canal</th>
                                <th>Rendimiento / Resultado</th>
                                <th>Observaciones</th>
                                <th class="text-center">Acciones</th>

                            </tr>

                        </thead>

                        <tbody>

                        @foreach($animale->producciones as $produccion)

                            <tr>

                                <td>
                                    {{ $produccion->fecha_pesaje ?? '---' }}
                                </td>

                                <td>
                                    {{ ucfirst($produccion->tipo_registro ?? '---') }}
                                </td>

                                <td>

                                    @if($produccion->peso_vivo !== null)
                                        {{ number_format($produccion->peso_vivo, 2, ',', '.') }} Kg
                                    @else
                                        ---
                                    @endif

                                </td>

                                <td>

                                    @if($produccion->peso_canal !== null)
                                        {{ number_format($produccion->peso_canal, 2, ',', '.') }} Kg
                                    @else
                                        ---
                                    @endif

                                </td>

                                <td>

                                    @if(
                                        $produccion->tipo_registro === 'sacrificio' &&
                                        $produccion->resultado !== null
                                    )

                                        <strong>
                                            {{ number_format($produccion->resultado, 2, ',', '.') }} %
                                        </strong>

                                    @elseif(
                                        $produccion->tipo_registro === 'mensual' &&
                                        $produccion->resultado !== null
                                    )

                                        {{ number_format($produccion->resultado, 2, ',', '.') }} Kg

                                    @else

                                        ---

                                    @endif

                                </td>

                                <td>
                                    {{ $produccion->observaciones ?? '---' }}
                                </td>

                                <td class="text-center text-nowrap">

                                    <a href="{{ route('producciones.edit', $produccion->id) }}"
                                       class="btn btn-sm btn-outline-warning"
                                       title="Editar">
                                        ✏️
                                    </a>

                                    <form action="{{ route('producciones.destroy', $produccion->id) }}"
                                          method="POST"
                                          class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Eliminar"
                                                onclick="return confirm('¿Deseas eliminar este registro?')">
                                            🗑️
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="alert alert-secondary mb-0">

                    Este animal no tiene registros de producción.

                </div>

            @endif

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- HISTORIAL REPRODUCTIVO HEMBRA --}}
    {{-- ========================================================= --}}

    @if(
        $animale->sexo === 'Hembra' ||
        $animale->reproduccionesHembra->count() > 0
    )

        <div class="card shadow-sm mb-4">

            <div class="card-header bg-danger text-white">

                <strong>
                    🐷 Historial reproductivo
                </strong>

            </div>

            <div class="card-body">

                @if($animale->reproduccionesHembra->count() > 0)

                    <div class="table-responsive">

                        <table class="table table-bordered table-striped align-middle">

                            <thead>

                                <tr>

                                    <th>Fecha celo</th>
                                    <th>Tipo monta</th>
                                    <th>Fecha servicio</th>
                                    <th>Fecha probable parto</th>
                                    <th>Fecha parto</th>
                                    <th>Crías totales</th>
                                    <th>Crías vivas</th>
                                    <th>Estado</th>
                                    <th class="text-center">Acciones</th>

                                </tr>

                            </thead>

                            <tbody>

                            @foreach($animale->reproduccionesHembra as $reproduccion)

                                <tr>

                                    <td>
                                        {{ $reproduccion->fecha_celo ?? '---' }}
                                    </td>

                                    <td>
                                        {{ $reproduccion->tipo_monta ?? '---' }}
                                    </td>

                                    <td>
                                        {{ $reproduccion->fecha_servicio ?? '---' }}
                                    </td>

                                    <td>
                                        {{ $reproduccion->fecha_probable_parto ?? '---' }}
                                    </td>

                                    <td>
                                        {{ $reproduccion->fecha_parto ?? '---' }}
                                    </td>

                                    <td>
                                        {{ $reproduccion->crias_totales ?? '---' }}
                                    </td>

                                    <td>
                                        {{ $reproduccion->crias_vivas ?? '---' }}
                                    </td>

                                    <td>
                                        {{ $reproduccion->estado ?? '---' }}
                                    </td>

                                    <td class="text-center text-nowrap">

                                        <a href="{{ route('reproducciones.edit', $reproduccion->id) }}"
                                           class="btn btn-sm btn-outline-warning"
                                           title="Editar">
                                            ✏️
                                        </a>

                                        <form action="{{ route('reproducciones.destroy', $reproduccion->id) }}"
                                              method="POST"
                                              class="d-inline">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                    title="Eliminar"
                                                    onclick="return confirm('¿Deseas eliminar este registro?')">
                                                🗑️
                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="alert alert-secondary mb-0">

                        Esta hembra todavía no tiene registros reproductivos.

                    </div>

                @endif

            </div>

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- HISTORIAL REPRODUCTIVO MACHO --}}
    {{-- ========================================================= --}}

    @if(
        $animale->sexo === 'Macho' &&
        $animale->reproduccionesMacho->count() > 0
    )

        <div class="card shadow-sm mb-4">

            <div class="card-header bg-dark text-white">

                <strong>
                    🐗 Historial reproductivo como macho
                </strong>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered table-striped align-middle">

                        <thead>

                            <tr>

                                <th>Fecha servicio</th>
                                <th>Tipo de monta</th>
                                <th>Hembra</th>
                                <th>Estado</th>
                                <th class="text-center">Acciones</th>

                            </tr>

                        </thead>

                        <tbody>

                        @foreach($animale->reproduccionesMacho as $reproduccion)

                            <tr>

                                <td>
                                    {{ $reproduccion->fecha_servicio ?? '---' }}
                                </td>

                                <td>
                                    {{ $reproduccion->tipo_monta ?? '---' }}
                                </td>

                                <td>
                                    {{ $reproduccion->hembra->codigo ?? '---' }}
                                </td>

                                <td>
                                    {{ $reproduccion->estado ?? '---' }}
                                </td>

                                <td class="text-center text-nowrap">

                                    <a href="{{ route('reproducciones.edit', $reproduccion->id) }}"
                                       class="btn btn-sm btn-outline-warning"
                                       title="Editar">
                                        ✏️
                                    </a>

                                    <form action="{{ route('reproducciones.destroy', $reproduccion->id) }}"
                                          method="POST"
                                          class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Eliminar"
                                                onclick="return confirm('¿Deseas eliminar este registro?')">
                                            🗑️
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- HISTORIAL DE VENTAS --}}
    {{-- ========================================================= --}}

    @if($animale->ventas->count() > 0)

        <div class="card shadow-sm mb-4">

            <div class="card-header bg-secondary text-white">

                <strong>
                    💰 Historial de venta
                </strong>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered table-striped align-middle">

                        <thead>

                            <tr>

                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>Documento</th>
                                <th>Teléfono</th>
                                <th>Peso venta</th>
                                <th>Precio/Kg</th>
                                <th>Total</th>
                                <th class="text-center">Acciones</th>

                            </tr>

                        </thead>

                        <tbody>

                        @foreach($animale->ventas as $venta)

                            <tr>

                                <td>
                                    {{ $venta->fecha_venta ?? '---' }}
                                </td>

                                <td>
                                    {{ $venta->cliente ?? '---' }}
                                </td>

                                <td>
                                    {{ $venta->documento_cliente ?? '---' }}
                                </td>

                                <td>
                                    {{ $venta->telefono_cliente ?? '---' }}
                                </td>

                                <td>
                                    {{ $venta->peso_venta ?? '---' }} Kg
                                </td>

                                <td>
                                    ${{ number_format($venta->precio_kilo ?? 0, 0, ',', '.') }}
                                </td>

                                <td>
                                    ${{ number_format($venta->total_venta ?? 0, 0, ',', '.') }}
                                </td>

                                <td class="text-center text-nowrap">

                                    <a href="{{ route('ventas.edit', $venta->id) }}"
                                       class="btn btn-sm btn-outline-warning"
                                       title="Editar">
                                        ✏️
                                    </a>

                                    <form action="{{ route('ventas.destroy', $venta->id) }}"
                                          method="POST"
                                          class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Eliminar"
                                                onclick="return confirm('¿Deseas eliminar este registro?')">
                                            🗑️
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- ACCIONES DEL ANIMAL --}}
    {{-- ========================================================= --}}

    <div class="card shadow-sm mb-4">

        <div class="card-header bg-dark text-white">

            <strong>
                🔗 Acciones
            </strong>

        </div>

        <div class="card-body">

            <div class="d-flex flex-wrap gap-2">

                <a href="{{ route('sanidades.create') }}"
                   class="btn btn-success btn-sm"
                   title="Registrar sanidad">
                    🩺
                </a>

                <a href="{{ route('producciones.create') }}"
                   class="btn btn-warning btn-sm"
                   title="Registrar producción">
                    ⚖️
                </a>

                <a href="{{ route('reproducciones.create') }}"
                   class="btn btn-danger btn-sm"
                   title="Registrar reproducción">
                    🐷
                </a>

                <a href="{{ route('animales.edit', $animale->id) }}"
                   class="btn btn-secondary btn-sm"
                   title="Editar animal">
                    ✏️
                </a>

            </div>

        </div>

    </div>

</div>

@endsection