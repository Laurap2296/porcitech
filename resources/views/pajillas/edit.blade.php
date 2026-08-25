@extends('layouts.app')

@section('content')

<div class="container">

<h2>Editar Pajilla</h2>

<form action="{{ route('pajillas.update', $pajilla->id) }}"
      method="POST">

@csrf
@method('PUT')

<div class="mb-3">
    <label>Código Pajilla</label>
    <input type="text"
           name="codigo_pajilla"
           value="{{ $pajilla->codigo_pajilla }}"
           class="form-control">
</div>

<div class="mb-3">
    <label>Raza</label>
    <input type="text"
           name="raza"
           value="{{ $pajilla->raza }}"
           class="form-control">
</div>

<div class="mb-3">
    <label>Línea Genética</label>
    <input type="text"
           name="linea_genetica"
           value="{{ $pajilla->linea_genetica }}"
           class="form-control">
</div>

<div class="mb-3">
    <label>Proveedor</label>
    <input type="text"
           name="proveedor"
           value="{{ $pajilla->proveedor }}"
           class="form-control">
</div>

<div class="mb-3">
    <label>Fecha Recolección</label>
    <input type="date"
           name="fecha_recoleccion"
           value="{{ $pajilla->fecha_recoleccion }}"
           class="form-control">
</div>

<div class="mb-3">
    <label>Estado</label>

    <select name="estado"
            class="form-control">

        <option value="Disponible"
        {{ $pajilla->estado == 'Disponible' ? 'selected' : '' }}>
        Disponible
        </option>

        <option value="Usada"
        {{ $pajilla->estado == 'Usada' ? 'selected' : '' }}>
        Usada
        </option>

        <option value="Vencida"
        {{ $pajilla->estado == 'Vencida' ? 'selected' : '' }}>
        Vencida
        </option>

    </select>

</div>

<div class="mb-3">
    <label>Observaciones</label>

    <textarea name="observaciones"
              class="form-control">{{ $pajilla->observaciones }}</textarea>
</div>

<button class="btn btn-primary">
    Actualizar
</button>

<a href="{{ route('pajillas.index') }}"
   class="btn btn-secondary">
   Volver
</a>

</form>

</div>

@endsection