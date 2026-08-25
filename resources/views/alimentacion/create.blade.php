@extends('layouts.app')

@section('content')

<div class="container">

<h2>Registrar Alimentación</h2>

<form action="/alimentaciones" method="POST">

@csrf

<div class="mb-3">

    <label>Animal</label>

    <select
        name="animal_id"
        class="form-control"
        required>

        <option value="">
            Seleccione
        </option>

        @foreach($animales as $animal)

            <option value="{{ $animal->id }}">
                {{ $animal->codigo }}
                -
                {{ $animal->raza }}
            </option>

        @endforeach

    </select>

</div>

<div class="mb-3">

    <label>Tipo de Alimento</label>

    <input
        type="text"
        name="tipo_alimento"
        class="form-control"
        required>

</div>

<div class="mb-3">

    <label>Cantidad Suministrada</label>

    <input
        type="number"
        step="0.01"
        name="cantidad_suministrada"
        class="form-control"
        required>

</div>

<div class="mb-3">

    <label>Fecha</label>

    <input
        type="date"
        name="fecha"
        class="form-control"
        required>

</div>

<div class="mb-3">

    <label>Observaciones</label>

    <textarea
        name="observaciones"
        class="form-control"
        rows="4"></textarea>

</div>

<button class="btn btn-success">
    Guardar
</button>

<a href="/alimentaciones"
   class="btn btn-secondary">
   Cancelar
</a>

</form>

</div>

@endsection