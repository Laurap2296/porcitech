@extends('layouts.app')

@section('content')

<div class="container">

<h2>Registrar Venta</h2>

<form action="{{ route('ventas.store') }}" method="POST">

@csrf

<div class="mb-3">

<label>Animal</label>

<select name="animal_id" class="form-select">

@foreach($animales as $animal)

<option value="{{ $animal->id }}">

{{ $animal->codigo }} - {{ $animal->raza }}

</option>

@endforeach

</select>

</div>

<div class="mb-3">

<label>Cliente</label>

<input type="text"
name="cliente"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Documento</label>

<input type="text"
name="documento_cliente"
class="form-control">

</div>

<div class="mb-3">

<label>Teléfono</label>

<input type="text"
name="telefono_cliente"
class="form-control">

</div>

<div class="mb-3">

<label>Fecha Venta</label>

<input type="date"
name="fecha_venta"
class="form-control"
required>

</div>

<div class="row">

<div class="col-md-6">

<label>Peso Venta (Kg)</label>

<input type="number"
step="0.01"
name="peso_venta"
class="form-control"
required>

</div>

<div class="col-md-6">

<label>Precio por Kg</label>

<input type="number"
step="0.01"
name="precio_kilo"
class="form-control"
required>

</div>

</div>

<div class="mt-3">

<label>Observaciones</label>

<textarea
name="observaciones"
class="form-control"
rows="3"></textarea>

</div>

<br>

<button class="btn btn-success">

Guardar Venta

</button>

<a href="{{ route('ventas.index') }}"
class="btn btn-secondary">

Cancelar

</a>

</form>

</div>

@endsection