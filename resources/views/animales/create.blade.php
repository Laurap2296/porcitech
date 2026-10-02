@extends('layouts.app')

@section('content')

<h2>Registrar Animal</h2>

{{-- MENSAJE GENERAL DE ERRORES --}}
@if ($errors->any()) <div class="alert alert-danger"> <strong>Se encontraron errores:</strong> <ul class="mb-0 mt-2">
@foreach ($errors->all() as $error) <li>{{ $error }}</li>
@endforeach </ul> </div>
@endif

<form action="{{ route('animales.store') }}" method="POST">

```
@csrf

<div class="row">

    {{-- CÓDIGO --}}
    <div class="col-md-6 mb-3">
        <label>Código</label>

        <input type="text"
               name="codigo"
               value="{{ old('codigo') }}"
               class="form-control @error('codigo') is-invalid @enderror"
               required>

        @error('codigo')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    {{-- RAZA --}}
    <div class="col-md-6 mb-3">
        <label>Raza</label>

        <input type="text"
               name="raza"
               value="{{ old('raza') }}"
               class="form-control @error('raza') is-invalid @enderror"
               required>

        @error('raza')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    {{-- SEXO --}}
    <div class="col-md-6 mb-3">
        <label>Sexo</label>

        <select name="sexo"
                class="form-control @error('sexo') is-invalid @enderror">

            <option value="Macho"
                {{ old('sexo', 'Macho') == 'Macho' ? 'selected' : '' }}>
                Macho
            </option>

            <option value="Hembra"
                {{ old('sexo') == 'Hembra' ? 'selected' : '' }}>
                Hembra
            </option>

        </select>

        @error('sexo')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    {{-- FECHA NACIMIENTO --}}
    <div class="col-md-6 mb-3">
        <label>Fecha Nacimiento</label>

        <input type="date"
               name="fecha_nacimiento"
               value="{{ old('fecha_nacimiento') }}"
               class="form-control @error('fecha_nacimiento') is-invalid @enderror"
               required>

        @error('fecha_nacimiento')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    {{-- PESO --}}
    <div class="col-md-6 mb-3">
        <label>Peso Actual (Kg)</label>

        <input type="number"
               step="0.01"
               name="peso_actual"
               value="{{ old('peso_actual') }}"
               class="form-control @error('peso_actual') is-invalid @enderror"
               required>

        @error('peso_actual')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    {{-- ETAPA --}}
    <div class="col-md-6 mb-3">
        <label>Etapa</label>

        <select name="etapa"
                class="form-control @error('etapa') is-invalid @enderror">

            <option value="Lechon"
                {{ old('etapa', 'Lechon') == 'Lechon' ? 'selected' : '' }}>
                Lechón
            </option>

            <option value="Levante"
                {{ old('etapa') == 'Levante' ? 'selected' : '' }}>
                Levante
            </option>

            <option value="Ceba"
                {{ old('etapa') == 'Ceba' ? 'selected' : '' }}>
                Ceba
            </option>

            <option value="Reproductor"
                {{ old('etapa') == 'Reproductor' ? 'selected' : '' }}>
                Reproductor
            </option>

        </select>

        @error('etapa')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    {{-- ORIGEN --}}
    <div class="col-md-6 mb-3">
        <label>Origen</label>

        <select name="origen"
                id="origen"
                class="form-control @error('origen') is-invalid @enderror">

            <option value="Nacido"
                {{ old('origen', 'Nacido') == 'Nacido' ? 'selected' : '' }}>
                Nacido
            </option>

            <option value="Comprado"
                {{ old('origen') == 'Comprado' ? 'selected' : '' }}>
                Comprado
            </option>

        </select>

        @error('origen')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    {{-- ESTADO --}}
    <div class="col-md-6 mb-3">
        <label>Estado</label>

        <select name="estado"
                class="form-control @error('estado') is-invalid @enderror">

            <option value="Activo"
                {{ old('estado', 'Activo') == 'Activo' ? 'selected' : '' }}>
                Activo
            </option>

            <option value="Vendido"
                {{ old('estado') == 'Vendido' ? 'selected' : '' }}>
                Vendido
            </option>

            <option value="Muerto"
                {{ old('estado') == 'Muerto' ? 'selected' : '' }}>
                Muerto
            </option>

        </select>

        @error('estado')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    {{-- GRANJA --}}
    <div class="col-md-6 mb-3">
        <label>Granja</label>

        <select name="granja_id"
                class="form-control @error('granja_id') is-invalid @enderror"
                required>

            <option value="">Seleccione una granja</option>

            @foreach($granjas as $granja)

                <option value="{{ $granja->id }}"
                    {{ old('granja_id') == $granja->id ? 'selected' : '' }}>
                    {{ $granja->nombre }}
                </option>

            @endforeach

        </select>

        @error('granja_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    {{-- DATOS DE COMPRA --}}
    <div id="datosCompra" class="row">

        <div class="col-md-6 mb-3">
            <label>Fecha Ingreso</label>

            <input type="date"
                   name="fecha_ingreso"
                   value="{{ old('fecha_ingreso') }}"
                   class="form-control">
        </div>

        <div class="col-md-6 mb-3">
            <label>Proveedor</label>

            <input type="text"
                   name="proveedor"
                   value="{{ old('proveedor') }}"
                   class="form-control">
        </div>

    </div>

    {{-- DATOS DE NACIMIENTO --}}
    <div id="datosNacimiento" class="row">

        <div class="col-md-6 mb-3">
            <label>Madre</label>

            <select name="madre_id" class="form-control">

                <option value="">Seleccione</option>

                @foreach($madres as $madre)

                    <option value="{{ $madre->id }}"
                        {{ old('madre_id') == $madre->id ? 'selected' : '' }}>
                        {{ $madre->codigo }}
                    </option>

                @endforeach

            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label>Padre</label>

            <select name="padre_id" class="form-control">

                <option value="">Seleccione</option>

                @foreach($padres as $padre)

                    <option value="{{ $padre->id }}"
                        {{ old('padre_id') == $padre->id ? 'selected' : '' }}>
                        {{ $padre->codigo }}
                    </option>

                @endforeach

            </select>
        </div>

    </div>

    {{-- OBSERVACIONES --}}
    <div class="col-md-12 mb-3">
        <label>Observaciones</label>

        <textarea name="observaciones"
                  class="form-control"
                  rows="4">{{ old('observaciones') }}</textarea>
    </div>

</div>

<button type="submit" class="btn btn-success">
    Guardar Animal
</button>

<a href="{{ route('animales.index') }}"
   class="btn btn-secondary">
   Cancelar
</a>
```

</form>

<script>

function cambiarOrigen()
{
    let origen = document.getElementById('origen').value;

    if(origen === 'Comprado')
    {
        document.getElementById('datosCompra').style.display = 'flex';
        document.getElementById('datosNacimiento').style.display = 'none';
    }
    else
    {
        document.getElementById('datosCompra').style.display = 'none';
        document.getElementById('datosNacimiento').style.display = 'flex';
    }
}

document.addEventListener('DOMContentLoaded', function(){

    cambiarOrigen();

    document.getElementById('origen')
        .addEventListener('change', cambiarOrigen);

});

</script>

@endsection
