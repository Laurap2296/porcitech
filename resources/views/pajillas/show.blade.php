@extends('layouts.app')

@section('content')

<div class="container">

<h2>Detalle Pajilla</h2>

<ul class="list-group">

<li class="list-group-item">
    Código:
    {{ $pajilla->codigo_pajilla }}
</li>

<li class="list-group-item">
    Raza:
    {{ $pajilla->raza }}
</li>

<li class="list-group-item">
    Línea Genética:
    {{ $pajilla->linea_genetica }}
</li>

<li class="list-group-item">
    Proveedor:
    {{ $pajilla->proveedor }}
</li>

<li class="list-group-item">
    Fecha Recolección:
    {{ $pajilla->fecha_recoleccion }}
</li>

<li class="list-group-item">
    Estado:
    {{ $pajilla->estado }}
</li>

<li class="list-group-item">
    Observaciones:
    {{ $pajilla->observaciones }}
</li>

</ul>

<a href="{{ route('pajillas.index') }}"
   class="btn btn-secondary mt-3">
   Volver
</a>

</div>

@endsection