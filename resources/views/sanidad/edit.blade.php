@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h2 class="mb-0">
            Editar Registro Sanitario
        </h2>

        {{-- REGRESAR --}}
        <a href="{{ route('sanidades.index') }}"
           class="btn btn-secondary">

            <i class="bi bi-arrow-left"></i>
            Regresar

        </a>

    </div>


    <div class="card shadow">

        <div class="card-body">

            <form action="{{ route('sanidades.update', $sanidad->id) }}"
                  method="POST">

                @csrf
                @method('PUT')


                {{-- ANIMAL --}}
                <div class="mb-3">

                    <label class="form-label">
                        Animal
                    </label>

                    <select name="animal_id"
                            class="form-control"
                            required>

                        @foreach($animales as $animal)

                            <option value="{{ $animal->id }}"
                                {{ $animal->id == $sanidad->animal_id ? 'selected' : '' }}>

                                {{ $animal->codigo }} - {{ $animal->raza }}

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- TIPO REGISTRO --}}
                <div class="mb-3">

                    <label class="form-label">
                        Tipo Registro
                    </label>

                    <select name="tipo_registro"
                            class="form-control"
                            required>

                        <option value="Vacunacion"
                            {{ $sanidad->tipo_registro == 'Vacunacion' ? 'selected' : '' }}>

                            Vacunación

                        </option>

                        <option value="Desparasitacion"
                            {{ $sanidad->tipo_registro == 'Desparasitacion' ? 'selected' : '' }}>

                            Desparasitación

                        </option>

                        <option value="Tratamiento"
                            {{ $sanidad->tipo_registro == 'Tratamiento' ? 'selected' : '' }}>

                            Tratamiento

                        </option>

                        <option value="Control"
                            {{ $sanidad->tipo_registro == 'Control' ? 'selected' : '' }}>

                            Control

                        </option>

                    </select>

                </div>


                {{-- NOMBRE --}}
                <div class="mb-3">

                    <label class="form-label">
                        Nombre
                    </label>

                    <input type="text"
                           name="nombre"
                           class="form-control"
                           value="{{ $sanidad->nombre }}"
                           required>

                </div>


                {{-- FECHA --}}
                <div class="mb-3">

                    <label class="form-label">
                        Fecha
                    </label>

                    <input type="date"
                           name="fecha"
                           class="form-control"
                           value="{{ $sanidad->fecha }}"
                           required>

                </div>


                {{-- PROXIMA FECHA --}}
                <div class="mb-3">

                    <label class="form-label">
                        Próxima Fecha
                    </label>

                    <input type="date"
                           name="proxima_fecha"
                           class="form-control"
                           value="{{ $sanidad->proxima_fecha }}">

                </div>


                {{-- DIAGNOSTICO --}}
                <div class="mb-3">

                    <label class="form-label">
                        Diagnóstico
                    </label>

                    <textarea name="diagnostico"
                              class="form-control"
                              rows="3">{{ $sanidad->diagnostico }}</textarea>

                </div>


                {{-- OBSERVACIONES --}}
                <div class="mb-3">

                    <label class="form-label">
                        Observaciones
                    </label>

                    <textarea name="observaciones"
                              class="form-control"
                              rows="3">{{ $sanidad->observaciones }}</textarea>

                </div>


                {{-- BOTONES --}}
                <div class="d-flex gap-2">

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="bi bi-save"></i>
                        Actualizar

                    </button>


                    <a href="{{ route('sanidades.index') }}"
                       class="btn btn-secondary">

                        <i class="bi bi-arrow-left"></i>
                        Regresar

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection