@extends('layouts.app')

@section('content')

<div class="container">

<h2>Editar Venta</h2>

<form action="{{ route('ventas.update',$venta->id) }}" method="POST">

@csrf
@method('PUT')

<div class="mb-3">

<label>Animal</label>

<select name="animal_id" class="form-select">

@foreach($animales as $animal)

<option value="{{ $animal->id }}"
{{ $animal->id == $venta->animal_id ? 'selected' : '' }}>

{{ $animal->codigo }} - {{ $animal->raza }}

</option>

@endforeach

</select>

</div>

<div class="mb-3">

<label>Cliente</label>

<input
type="text"
name="cliente"
class="form-control"
value="{{ old('cliente',$venta->cliente) }}">

</div>

<div class="mb-3">

<label>Documento</label>

<input
type="text"
name="documento_cliente"
class="form-control"
value="{{ old('documento_cliente',$venta->documento_cliente) }}">

</div>

<div class="mb-3">

<label>Teléfono</label>

<input
type="text"
name="telefono_cliente"
class="form-control"
value="{{ old('telefono_cliente',$venta->telefono_cliente) }}">

</div>

<div class="mb-3">

<label>Fecha Venta</label>

<input
type="date"
name="fecha_venta"
class="form-control"
value="{{ old('fecha_venta',$venta->fecha_venta) }}">

</div>

<div class="row">

<div class="col-md-6">

<label>Peso Venta</label>

<input
type="number"
step="0.01"
name="peso_venta"
class="form-control"
value="{{ old('peso_venta',$venta->peso_venta) }}">

</div>

<div class="col-md-6">

<label>Precio por Kg</label>

<input
type="number"
step="0.01"
name="precio_kilo"
class="form-control"
value="{{ old('precio_kilo',$venta->precio_kilo) }}">

</div>

</div>

<div class="mt-3">

<label>Observaciones</label>

<textarea
name="observaciones"
class="form-control"
rows="3">{{ old('observaciones',$venta->observaciones) }}</textarea>

</div>

<br>

<button class="btn btn-warning">

Actualizar Venta

</button>

<a href="{{ route('ventas.index') }}"
class="btn btn-secondary">

Cancelar

</a>

</form>

</div>

@endsection