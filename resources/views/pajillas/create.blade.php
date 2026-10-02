```blade
@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Registrar Pajilla</h2>

    {{-- Mensaje de error general --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Por favor, revise los siguientes errores:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pajillas.store') }}" method="POST">

        @csrf

        <div class="mb-3">
            <label>Código Pajilla</label>
            <input type="text"
                   name="codigo_pajilla"
                   class="form-control @error('codigo_pajilla') is-invalid @enderror"
                   value="{{ old('codigo_pajilla') }}"
                   required>

            @error('codigo_pajilla')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Raza</label>
            <input type="text"
                   name="raza"
                   class="form-control"
                   value="{{ old('raza') }}"
                   required>
        </div>

        <div class="mb-3">
            <label>Línea Genética</label>
            <input type="text"
                   name="linea_genetica"
                   class="form-control"
                   value="{{ old('linea_genetica') }}">
        </div>

        <div class="mb-3">
            <label>Proveedor</label>
            <input type="text"
                   name="proveedor"
                   class="form-control"
                   value="{{ old('proveedor') }}">
        </div>

        <div class="mb-3">
            <label>Fecha Recolección</label>
            <input type="date"
                   name="fecha_recoleccion"
                   class="form-control"
                   value="{{ old('fecha_recoleccion') }}">
        </div>

        <div class="mb-3">
            <label>Estado</label>
            <select name="estado" class="form-control">
                <option value="Disponible" {{ old('estado') == 'Disponible' ? 'selected' : '' }}>
                    Disponible
                </option>
                <option value="Usada" {{ old('estado') == 'Usada' ? 'selected' : '' }}>
                    Usada
                </option>
                <option value="Vencida" {{ old('estado') == 'Vencida' ? 'selected' : '' }}>
                    Vencida
                </option>
            </select>
        </div>

        <div class="mb-3">
            <label>Observaciones</label>
            <textarea name="observaciones"
                      class="form-control">{{ old('observaciones') }}</textarea>
        </div>

        {{-- Botones --}}
        <a href="{{ route('pajillas.index') }}" class="btn btn-secondary">
            Volver
        </a>

        <button type="submit" class="btn btn-success">
            Guardar
        </button>

    </form>

</div>

@endsection
```