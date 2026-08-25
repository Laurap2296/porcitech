@extends('layouts.app')

@section('title', 'Editar Producción')

@section('content')

<div class="container">

    <div class="card shadow">

        {{-- ENCABEZADO --}}
        <div class="card-header bg-success text-white">

            <div class="d-flex justify-content-between align-items-center">

                <h4 class="mb-0">
                    <i class="bi bi-pencil-square"></i>
                    Editar Registro de Producción
                </h4>

                <a href="{{ route('producciones.index') }}"
                   class="btn btn-light">

                    <i class="bi bi-arrow-left"></i>
                    Volver

                </a>

            </div>

        </div>


        <div class="card-body">

            <form action="{{ route('producciones.update', $produccion->id) }}"
                  method="POST">

                @csrf
                @method('PUT')


                {{-- ANIMAL --}}
                <div class="mb-3">

                    <label class="form-label fw-bold">
                        Animal
                    </label>

                    <select name="animal_id"
                            class="form-select"
                            required>

                        <option value="">
                            Seleccione un animal
                        </option>

                        @foreach($animales as $animal)

                            <option value="{{ $animal->id }}"
                                {{ old(
                                    'animal_id',
                                    $produccion->animal_id
                                ) == $animal->id ? 'selected' : '' }}>

                                {{ $animal->codigo }}

                                @if($animal->raza)
                                    - {{ $animal->raza }}
                                @endif

                                - {{ $animal->estado }}

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- FECHA --}}
                <div class="mb-3">

                    <label class="form-label fw-bold">
                        Fecha
                    </label>

                    <input type="date"
                           name="fecha_pesaje"
                           class="form-control"
                           value="{{ old(
                               'fecha_pesaje',
                               \Carbon\Carbon::parse(
                                   $produccion->fecha_pesaje
                               )->format('Y-m-d')
                           ) }}"
                           required>

                </div>


                {{-- TIPO --}}
                <div class="mb-3">

                    <label class="form-label fw-bold">
                        Tipo de registro
                    </label>

                    <select name="tipo_registro"
                            id="tipo_registro"
                            class="form-select"
                            required>

                        <option value="mensual"
                            {{ old(
                                'tipo_registro',
                                $produccion->tipo_registro
                            ) == 'mensual' ? 'selected' : '' }}>

                            Mensual

                        </option>

                        <option value="sacrificio"
                            {{ old(
                                'tipo_registro',
                                $produccion->tipo_registro
                            ) == 'sacrificio' ? 'selected' : '' }}>

                            Sacrificio

                        </option>

                    </select>

                </div>


                {{-- PESO VIVO --}}
                <div class="mb-3">

                    <label class="form-label fw-bold">
                        Peso vivo (Kg)
                    </label>

                    <input type="number"
                           step="0.01"
                           min="0"
                           name="peso_vivo"
                           class="form-control"
                           value="{{ old(
                               'peso_vivo',
                               $produccion->peso_vivo
                           ) }}">

                </div>


                {{-- PESO CANAL --}}
                <div class="mb-3">

                    <label class="form-label fw-bold">
                        Peso canal (Kg)
                    </label>

                    <input type="number"
                           step="0.01"
                           min="0"
                           name="peso_canal"
                           class="form-control"
                           value="{{ old(
                               'peso_canal',
                               $produccion->peso_canal
                           ) }}">

                    <small class="text-muted">

                        Solo se utiliza para registros de sacrificio.

                    </small>

                </div>


                {{-- RESULTADO ACTUAL --}}
                <div class="mb-3">

                    <label class="form-label fw-bold">
                        Resultado calculado
                    </label>

                    <div class="alert alert-info mb-0">

                        @if($produccion->tipo_registro === 'sacrificio')

                            @if($produccion->resultado !== null)

                                Rendimiento actual:

                                <strong>
                                    {{ number_format(
                                        $produccion->resultado,
                                        2
                                    ) }} %
                                </strong>

                            @else

                                No calculado.

                            @endif

                        @else

                            @if($produccion->resultado !== null)

                                Ganancia de peso:

                                <strong>
                                    {{ number_format(
                                        $produccion->resultado,
                                        2
                                    ) }} Kg
                                </strong>

                            @else

                                No calculado.

                            @endif

                        @endif

                    </div>

                </div>


                {{-- OBSERVACIONES --}}
                <div class="mb-3">

                    <label class="form-label fw-bold">
                        Observaciones
                    </label>

                    <textarea name="observaciones"
                              class="form-control"
                              rows="3">{{ old(
                                  'observaciones',
                                  $produccion->observaciones
                              ) }}</textarea>

                </div>


                {{-- BOTONES --}}
                <div class="d-flex gap-2">

                    <button type="submit"
                            class="btn btn-success">

                        <i class="bi bi-save"></i>
                        Guardar cambios

                    </button>


                    <a href="{{ route('producciones.index') }}"
                       class="btn btn-secondary">

                        <i class="bi bi-arrow-left"></i>
                        Cancelar

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection