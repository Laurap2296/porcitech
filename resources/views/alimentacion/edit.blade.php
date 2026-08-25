@extends('layouts.app')

@section('title', 'Ajuste de Alimentación')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header bg-success text-white">

            <h4 class="mb-0">

                <i class="bi bi-pencil-square"></i>

                Ajuste de Alimentación

            </h4>

        </div>


        <div class="card-body">

            {{-- ERRORES --}}
            @if($errors->any())

                <div class="alert alert-danger">

                    <strong>
                        Revise los siguientes errores:
                    </strong>

                    <ul class="mb-0 mt-2">

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- INFORMACIÓN DEL ANIMAL --}}
            <div class="alert alert-info">

                <h5 class="mb-3">

                    <i class="bi bi-piggy-bank"></i>

                    Animal {{ $animal->codigo }}

                </h5>


                <div class="row">

                    <div class="col-md-3">

                        <strong>Sexo:</strong>

                        <br>

                        {{ $animal->sexo }}

                    </div>


                    <div class="col-md-3">

                        <strong>Etapa:</strong>

                        <br>

                        {{ $animal->etapa }}

                    </div>


                    <div class="col-md-3">

                        <strong>Peso actual:</strong>

                        <br>

                        {{ number_format(
                            $animal->peso_actual,
                            2
                        ) }}
                        kg

                    </div>


                    <div class="col-md-3">

                        <strong>Condición:</strong>

                        <br>

                        {{ $condicionReproductiva ?? '—' }}

                    </div>

                </div>

            </div>


            {{-- DATOS AUTOMÁTICOS --}}
            <div class="card mb-4">

                <div class="card-header">

                    <strong>
                        Información automática del sistema
                    </strong>

                </div>


                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6">

                            <label class="form-label">
                                Ración recomendada
                            </label>

                            @if($racionRecomendada)

                                <div class="form-control bg-light">

                                    <strong>
                                        {{ $racionRecomendada->tipo_alimento }}
                                    </strong>

                                    <br>

                                    <small>
                                        {{ $racionRecomendada->nombre }}
                                    </small>

                                </div>

                            @else

                                <div class="form-control bg-light">

                                    Sin ración definida

                                </div>

                            @endif

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">

                                Cantidad automática

                            </label>

                            <div class="form-control bg-light">

                                @if($cantidadRecomendada !== null)

                                    <strong>

                                        {{ number_format(
                                            $cantidadRecomendada,
                                            2
                                        ) }}

                                        kg/día

                                    </strong>

                                    <span class="badge bg-secondary ms-2">

                                        Automática

                                    </span>

                                @else

                                    Sin cantidad definida

                                @endif

                            </div>

                        </div>

                    </div>


                    @if($diasGestacion)

                        <div class="mt-3">

                            <strong>
                                Días de gestación:
                            </strong>

                            {{ $diasGestacion }}

                        </div>

                    @endif

                </div>

            </div>


            {{-- FORMULARIO DE AJUSTE --}}
            <form
                action="{{ route(
                    'alimentaciones.ajuste.update',
                    $animal->id
                ) }}"
                method="POST"
            >

                @csrf

                @method('PUT')


                <div class="card mb-4">

                    <div class="card-header bg-warning">

                        <strong>

                            <i class="bi bi-sliders"></i>

                            Ajuste manual

                        </strong>

                    </div>


                    <div class="card-body">

                        <div class="mb-3">

                            <label
                                for="cantidad_ajustada"
                                class="form-label"
                            >

                                Cantidad ajustada
                                <span class="text-danger">*</span>

                            </label>


                            <div class="input-group">

                                <input
                                    type="number"
                                    name="cantidad_ajustada"
                                    id="cantidad_ajustada"
                                    class="form-control"
                                    step="0.01"
                                    min="0.01"
                                    value="{{ old(
                                        'cantidad_ajustada',
                                        $animal->cantidad_ajustada
                                    ) }}"
                                    required
                                >

                                <span class="input-group-text">
                                    kg/día
                                </span>

                            </div>


                            <small class="text-muted">

                                Esta cantidad reemplazará temporalmente
                                la cantidad automática.

                            </small>

                        </div>


                        <div class="mb-3">

                            <label
                                for="observacion_alimentacion"
                                class="form-label"
                            >

                                Motivo del ajuste
                                <span class="text-danger">*</span>

                            </label>


                            <textarea
                                name="observacion_alimentacion"
                                id="observacion_alimentacion"
                                class="form-control"
                                rows="4"
                                required
                            >{{ old(
                                'observacion_alimentacion',
                                $animal->observacion_alimentacion
                            ) }}</textarea>


                            <small class="text-muted">

                                Registre por qué se modificó temporalmente
                                la cantidad de alimento.

                            </small>

                        </div>

                    </div>

                </div>


                {{-- BOTONES --}}
                <div class="d-flex justify-content-between">

                    <a
                        href="{{ route('alimentaciones.index') }}"
                        class="btn btn-secondary"
                    >

                        <i class="bi bi-arrow-left"></i>

                        Volver

                    </a>


                    <button
                        type="submit"
                        class="btn btn-success"
                    >

                        <i class="bi bi-check-circle"></i>

                        Guardar ajuste

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection