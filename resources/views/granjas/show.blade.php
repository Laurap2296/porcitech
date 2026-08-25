@extends('layouts.app')

@section('content')

<h2>Detalle de Granja</h2>

<div class="card">

    <div class="card-body">

        <p><strong>Nombre:</strong> {{ $granja->nombre }}</p>

        <p><strong>Ubicación:</strong> {{ $granja->ubicacion }}</p>

        <p><strong>Propietario:</strong> {{ $granja->propietario }}</p>

        <p><strong>Teléfono:</strong> {{ $granja->telefono }}</p>

        <p><strong>Estado:</strong> {{ $granja->estado }}</p>

    </div>

</div>

<a href="{{ route('granjas.index') }}"
   class="btn btn-secondary mt-3">
    Volver
</a>

@endsection