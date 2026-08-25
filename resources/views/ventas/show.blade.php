@extends('layouts.app')

@section('content')

<div class="container">

<div class="card">

<div class="card-header bg-success text-white">

<h4>Detalle de la Venta</h4>

</div>

<div class="card-body">

<table class="table table-bordered">

<tr>

<th>Animal</th>

<td>{{ $venta->animal->codigo }}</td>

</tr>

<tr>

<th>Cliente</th>

<td>{{ $venta->cliente }}</td>

</tr>

<tr>

<th>Documento</th>

<td>{{ $venta->documento_cliente }}</td>

</tr>

<tr>

<th>Teléfono</th>

<td>{{ $venta->telefono_cliente }}</td>

</tr>

<tr>

<th>Fecha</th>

<td>{{ $venta->fecha_venta }}</td>

</tr>

<tr>

<th>Peso</th>

<td>{{ $venta->peso_venta }} Kg</td>

</tr>

<tr>

<th>Precio por Kg</th>

<td>${{ number_format($venta->precio_kilo,0,',','.') }}</td>

</tr>

<tr>

<th>Total Venta</th>

<td>

<strong>

${{ number_format($venta->total_venta,0,',','.') }}

</strong>

</td>

</tr>

<tr>

<th>Observaciones</th>

<td>{{ $venta->observaciones }}</td>

</tr>

</table>

<a href="{{ route('ventas.index') }}"
class="btn btn-secondary">

Volver

</a>

</div>

</div>

</div>

@endsection