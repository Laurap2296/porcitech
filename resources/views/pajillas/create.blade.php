@extends('layouts.app')

@section('content')

<div class="container">

<h2>Registrar Pajilla</h2>

<form action="{{ route('pajillas.store') }}" method="POST">

@csrf

<div class="mb-3">
    <label>Código Pajilla</label>
    <input type="text" name="codigo_pajilla" class="form-control" required>
</div>

<div class="mb-3">
    <label>Raza</label>
    <input type="text" name="raza" class="form-control" required>
</div>

<div class="mb-3">
    <label>Línea Genética</label>
    <input type="text" name="linea_genetica" class="form-control">
</div>

<div class="mb-3">
    <label>Proveedor</label>
    <input type="text" name="proveedor" class="form-control">
</div>

<div class="mb-3">
    <label>Fecha Recolección</label>
    <input type="date" name="fecha_recoleccion" class="form-control">
</div>

<div class="mb-3">
    <label>Estado</label>
    <select name="estado" class="form-control">
        <option value="Disponible">Disponible</option>
        <option value="Usada">Usada</option>
        <option value="Vencida">Vencida</option>
    </select>
</div>

<div class="mb-3">
    <label>Observaciones</label>
    <textarea name="observaciones" class="form-control"></textarea>
</div>

<button class="btn btn-success">
    Guardar
</button>

</form>

</div>

@endsection