@extends('layouts.app')

@section('content')

<div class="container">

<h2>Detalle Alimentación</h2>

<ul class="list-group">

<li class="list-group-item">
Animal:
{{ $alimentacion->animal->codigo ?? 'N/A' }}
</li>

<li class="list-group-item">
Tipo:
{{ $alimentacion->tipo_alimento }}
</li>

<li class="list-group-item">
Cantidad:
{{ $alimentacion->cantidad_suministrada }}
</li>

<li class="list-group-item">
Fecha:
{{ $alimentacion->fecha }}
</li>

<li class="list-group-item">
Observaciones:
{{ $alimentacion->observaciones }}
</li>

</ul>

<a href="/alimentaciones"
   class="btn btn-secondary mt-3">
   Volver
</a>

</div>

@endsection