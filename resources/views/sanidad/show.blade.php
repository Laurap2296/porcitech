@extends('layouts.app')

@section('content')

<div class="container">

<h2>Detalle Sanitario</h2>

<p><b>Animal:</b> {{ $sanidad->animal->codigo ?? '' }}</p>
<p><b>Tipo:</b> {{ $sanidad->tipo_registro }}</p>
<p><b>Nombre:</b> {{ $sanidad->nombre }}</p>
<p><b>Fecha:</b> {{ $sanidad->fecha }}</p>
<p><b>Próxima Fecha:</b> {{ $sanidad->proxima_fecha }}</p>
<p><b>Diagnóstico:</b> {{ $sanidad->diagnostico }}</p>
<p><b>Observaciones:</b> {{ $sanidad->observaciones }}</p>

<a href="{{ route('sanidades.index') }}" class="btn btn-secondary">
    Volver
</a>

</div>

@endsection