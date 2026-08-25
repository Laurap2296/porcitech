@extends('layouts.app')

@section('title', 'Actualizar peso')

@section('content')

<div class="container-fluid">

    <div class="card shadow">

        <div class="card-header bg-success text-white">
            <h4 class="mb-0">
                <i class="bi bi-pencil-square"></i>
                Actualizar peso del animal
            </h4>
        </div>

        <div class="card-body">

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle"></i>
                    {{ session('error') }}
                </div>
            @endif

            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i>

                El peso ingresado aquí se actualizará también
                automáticamente en el módulo <strong>Animales</strong>.
                La ración recomendada se recalculará con el nuevo peso.
            </div>

            <div class="row">

                <div class="col-md-6">

                    <div class="card border-success mb-3">

                        <div class="card-body">

                            <h5 class="card-title">
                                Información del animal
                            </h5>

                            <p class="mb-2">
                                <strong>Código:</strong>
                                {{ $animal->codigo }}
                            </p>

                            <p class="mb-2">
                                <strong>Raza:</strong>
                                {{ $animal->raza ?? 'No registrada' }}
                            </p>

                            <p class="mb-2">
                                <strong>Sexo:</strong>
                                {{ $animal->sexo }}
                            </p>

                            <p class="mb-2">
                                <strong>Etapa:</strong>
                                {{ $animal->etapa }}
                            </p>

                            <p class="mb-0">
                                <strong>Peso actual:</strong>

                                @if(
                                    $animal->peso_actual !== null &&
                                    $animal->peso_actual > 0
                                )

                                    {{ number_format(
                                        $animal->peso_actual,
                                        2
                                    ) }}
                                    kg

                                @else

                                    <span class="text-warning">
                                        Pendiente
                                    </span>

                                @endif

                            </p>

                        </div>

                    </div>

                </div>


                <div class="col-md-6">

                    <form
                        action="{{ route(
                            'alimentaciones.peso.actualizar',
                            $animal->id
                        ) }}"
                        method="POST"
                    >

                        @csrf
                        @method('PUT')

                        <div class="mb-3">

                            <label
                                for="peso_actual"
                                class="form-label"
                            >
                                <strong>Nuevo peso (kg)</strong>
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                min="0.01"
                                name="peso_actual"
                                id="peso_actual"
                                class="form-control @error('peso_actual') is-invalid @enderror"
                                value="{{ old(
                                    'peso_actual',
                                    $animal->peso_actual
                                ) }}"
                                required
                            >

                            @error('peso_actual')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        <div class="d-flex gap-2">

                            <button
                                type="submit"
                                class="btn btn-success"
                            >

                                <i class="bi bi-save"></i>
                                Guardar peso

                            </button>


                            <a
                                href="{{ route(
                                    'alimentaciones.index'
                                ) }}"
                                class="btn btn-secondary"
                            >

                                <i class="bi bi-arrow-left"></i>
                                Volver

                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection