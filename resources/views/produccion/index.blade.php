@extends('layouts.app')

@section('content')

<style>
    .animal-title {
        color: #198754;
        font-weight: bold;
    }

    .tabla-produccion th {
        white-space: nowrap;
    }
</style>

<div class="container-fluid">

    {{-- =========================
        TÍTULO
    ========================== --}}
    <div class="d-flex justify-content-between align-items-center mb-3">

        <h2 class="text-success fw-bold">
            Historial de Producción
        </h2>

        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i>
            Volver
        </a>

    </div>


    {{-- =========================
        MENSAJE
    ========================== --}}
    @if(session('success'))

        <div class="alert alert-success">
            <i class="bi bi-check-circle"></i>
            {{ session('success') }}
        </div>

    @endif


    @if($errors->any())

        <div class="alert alert-danger">

            <strong>Se encontraron errores:</strong>

            <ul class="mb-0">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    {{-- ==========================================================
         NUEVO REGISTRO
    =========================================================== --}}
    <div class="card mb-4 shadow-sm">

        <div class="card-header bg-success text-white">

            <h5 class="mb-0">
                <i class="bi bi-plus-circle"></i>
                Nuevo Registro de Producción
            </h5>

        </div>


        <div class="card-body">

            <form action="{{ route('producciones.store') }}" method="POST">

                @csrf

                <div class="row">

                    {{-- ANIMAL --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label fw-bold">
                            Animal
                        </label>

                        <select
                            name="animal_id"
                            class="form-select"
                            required
                        >

                            <option value="">
                                Seleccione un animal
                            </option>

                            @foreach($animales as $animal)

                                <option value="{{ $animal->id }}">

                                    Animal {{ $animal->codigo ?? '---' }}

                                    @if($animal->raza)
                                        | {{ $animal->raza }}
                                    @endif

                                    @if($animal->etapa)
                                        | {{ $animal->etapa }}
                                    @endif

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- FECHA --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label fw-bold">
                            Fecha
                        </label>

                        <input
                            type="date"
                            name="fecha_pesaje"
                            class="form-control"
                            value="{{ old('fecha_pesaje') }}"
                            required
                        >

                    </div>


                    {{-- TIPO --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label fw-bold">
                            Tipo de Registro
                        </label>

                        <select
                            name="tipo_registro"
                            id="tipo_registro"
                            class="form-select"
                            required
                        >

                            <option value="mensual">
                                Mensual
                            </option>

                            <option value="sacrificio">
                                Sacrificio
                            </option>

                            <option value="muerto">
                                Muerto
                            </option>

                        </select>

                    </div>

                </div>


                <div class="row">

                    {{-- PESO VIVO --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label fw-bold">
                            Peso Vivo (Kg)
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            min="0"
                            name="peso_vivo"
                            id="peso_vivo"
                            class="form-control"
                            value="{{ old('peso_vivo') }}"
                        >

                        <small class="text-muted">
                            Obligatorio para sacrificio si se desea calcular rendimiento.
                        </small>

                    </div>


                    {{-- PESO CANAL --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label fw-bold">
                            Peso Canal (Kg)
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            min="0"
                            name="peso_canal"
                            id="peso_canal"
                            class="form-control"
                            value="{{ old('peso_canal') }}"
                        >

                        <small class="text-muted">
                            Solo aplica para animales sacrificados.
                        </small>

                    </div>


                    {{-- OBSERVACIONES --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label fw-bold">
                            Observaciones
                        </label>

                        <input
                            type="text"
                            name="observaciones"
                            class="form-control"
                            value="{{ old('observaciones') }}"
                            placeholder="Ej. Enfermedad, accidente, sacrificio..."
                        >

                    </div>

                </div>


                <div class="mt-2">

                    <button
                        type="submit"
                        class="btn btn-success"
                    >

                        <i class="bi bi-save"></i>
                        Guardar Registro

                    </button>

                </div>

            </form>

        </div>

    </div>


    {{-- ==========================================================
         HISTORIAL
    =========================================================== --}}
    <div class="card shadow-sm">

        <div class="card-header bg-success text-white">

            <h5 class="mb-0">

                <i class="bi bi-clock-history"></i>
                Historial por Animal

            </h5>

        </div>


        <div class="card-body">

            @forelse($producciones as $animalId => $registros)

                @php

                    $animal = $registros->first()->animal ?? null;

                @endphp


                {{-- =========================
                    DATOS DEL ANIMAL
                ========================== --}}
                <div class="d-flex justify-content-between align-items-center mt-4 mb-2">

                    <h5 class="animal-title mb-0">

                        🐷 Animal {{ $animal->codigo ?? '---' }}

                        @if($animal && $animal->raza)
                            | {{ $animal->raza }}
                        @endif

                        @if($animal && $animal->etapa)
                            | {{ $animal->etapa }}
                        @endif

                        @if($animal)

                            <span
                                class="badge
                                @if($animal->estado == 'Activo')
                                    bg-success
                                @elseif($animal->estado == 'Muerto')
                                    bg-danger
                                @elseif($animal->estado == 'Vendido')
                                    bg-warning text-dark
                                @else
                                    bg-secondary
                                @endif"
                            >

                                {{ $animal->estado }}

                            </span>

                        @endif

                    </h5>

                </div>


                {{-- =========================
                    TABLA
                ========================== --}}
                <div class="table-responsive">

                    <table class="table table-bordered table-hover text-center align-middle tabla-produccion">

                        <thead class="table-success text-dark">

                            <tr>

                                <th>#</th>

                                <th>Fecha</th>

                                <th>Tipo Registro</th>

                                <th>Peso Vivo</th>

                                <th>Peso Canal</th>

                                <th>Resultado</th>

                                <th>Observaciones</th>

                                <th>Acciones</th>

                            </tr>

                        </thead>


                        <tbody>

                            @php
                                $pesoAnterior = null;
                            @endphp


                            @foreach($registros as $p)

                                <tr
                                    @if($p->tipo_registro == 'sacrificio')
                                        class="table-danger"
                                    @elseif($p->tipo_registro == 'muerto')
                                        class="table-warning"
                                    @endif
                                >

                                    {{-- # --}}
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>


                                    {{-- FECHA --}}
                                    <td>

                                        {{ \Carbon\Carbon::parse(
                                            $p->fecha_pesaje
                                        )->format('d/m/Y') }}

                                    </td>


                                    {{-- TIPO --}}
                                    <td>

                                        @if($p->tipo_registro == 'sacrificio')

                                            <span class="badge bg-danger">

                                                <i class="bi bi-scissors"></i>
                                                Sacrificio

                                            </span>

                                        @elseif($p->tipo_registro == 'muerto')

                                            <span class="badge bg-warning text-dark">

                                                <i class="bi bi-heartbreak"></i>
                                                Muerto

                                            </span>

                                        @else

                                            <span class="badge bg-primary">

                                                <i class="bi bi-calendar-check"></i>
                                                Mensual

                                            </span>

                                        @endif

                                    </td>


                                    {{-- PESO VIVO --}}
                                    <td>

                                        @if($p->peso_vivo !== null)

                                            {{ number_format(
                                                $p->peso_vivo,
                                                2
                                            ) }}
                                            Kg

                                        @else

                                            ---

                                        @endif

                                    </td>


                                    {{-- PESO CANAL --}}
                                    <td>

                                        @if($p->peso_canal !== null)

                                            {{ number_format(
                                                $p->peso_canal,
                                                2
                                            ) }}
                                            Kg

                                        @else

                                            ---

                                        @endif

                                    </td>


                                    {{-- RESULTADO --}}
                                    <td>

                                        {{-- MENSUAL --}}
                                        @if($p->tipo_registro == 'mensual')

                                            @if($pesoAnterior === null)

                                                <span class="badge bg-secondary">
                                                    Primer registro
                                                </span>

                                            @elseif(
                                                $p->peso_vivo !== null &&
                                                $pesoAnterior !== null
                                            )

                                                @php

                                                    $ganancia =
                                                        $p->peso_vivo
                                                        - $pesoAnterior;

                                                @endphp


                                                @if($ganancia >= 0)

                                                    <span class="badge bg-success">

                                                        +{{ number_format(
                                                            $ganancia,
                                                            2
                                                        ) }}
                                                        Kg

                                                    </span>

                                                @else

                                                    <span class="badge bg-warning text-dark">

                                                        {{ number_format(
                                                            $ganancia,
                                                            2
                                                        ) }}
                                                        Kg

                                                    </span>

                                                @endif

                                            @else

                                                <span class="badge bg-secondary">
                                                    N/A
                                                </span>

                                            @endif


                                            @php

                                                if ($p->peso_vivo !== null) {
                                                    $pesoAnterior = $p->peso_vivo;
                                                }

                                            @endphp


                                        {{-- SACRIFICIO --}}
                                        @elseif($p->tipo_registro == 'sacrificio')

                                            @if(
                                                $p->peso_vivo !== null &&
                                                $p->peso_canal !== null &&
                                                $p->peso_vivo > 0
                                            )

                                                @php

                                                    $rendimiento =
                                                        (
                                                            $p->peso_canal /
                                                            $p->peso_vivo
                                                        ) * 100;

                                                @endphp


                                                <span class="badge bg-primary">

                                                    Rendimiento:
                                                    {{ number_format(
                                                        $rendimiento,
                                                        2
                                                    ) }}
                                                    %

                                                </span>

                                            @else

                                                <span class="badge bg-secondary">
                                                    Sin rendimiento
                                                </span>

                                            @endif


                                        {{-- MUERTO --}}
                                        @elseif($p->tipo_registro == 'muerto')

                                            <span class="badge bg-warning text-dark">

                                                <i class="bi bi-info-circle"></i>
                                                Sin rendimiento

                                            </span>

                                        @endif

                                    </td>


                                    {{-- OBSERVACIONES --}}
                                    <td>

                                        {{ $p->observaciones
                                            ?? 'Sin observaciones' }}

                                    </td>


                                    {{-- ACCIONES --}}
                                    <td>

                                        <div class="d-flex justify-content-center gap-1">

                                            {{-- EDITAR --}}
                                            <a
                                                href="{{ route(
                                                    'producciones.edit',
                                                    $p->id
                                                ) }}"
                                                class="btn btn-warning btn-sm"
                                                title="Editar"
                                            >

                                                <i class="bi bi-pencil-square"></i>
                                                Editar

                                            </a>


                                            {{-- ELIMINAR --}}
                                            <form
                                                action="{{ route(
                                                    'producciones.destroy',
                                                    $p->id
                                                ) }}"
                                                method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('¿Está seguro de eliminar este registro de producción?');"
                                            >

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-danger btn-sm"
                                                    title="Eliminar"
                                                >

                                                    <i class="bi bi-trash"></i>
                                                    Eliminar

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @empty

                <div class="alert alert-info text-center">

                    <i
                        class="bi bi-info-circle"
                        style="font-size: 35px;"
                    ></i>

                    <p class="mb-0 mt-2">
                        No existen registros de producción.
                    </p>

                </div>

            @endforelse

        </div>

    </div>

</div>


{{-- ==========================================================
     JAVASCRIPT
=========================================================== --}}
<script>

    document.addEventListener('DOMContentLoaded', function () {

        const tipo = document.getElementById('tipo_registro');
        const pesoCanal = document.getElementById('peso_canal');

        if (!tipo || !pesoCanal) {
            return;
        }

        function actualizarPesoCanal() {

            if (tipo.value === 'sacrificio') {

                pesoCanal.disabled = false;

            } else {

                pesoCanal.disabled = true;
                pesoCanal.value = '';

            }
        }

        actualizarPesoCanal();

        tipo.addEventListener(
            'change',
            actualizarPesoCanal
        );

    });

</script>

@endsection