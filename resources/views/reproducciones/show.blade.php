@extends('layouts.app')

@section('content')

<div class="container">

<h2>Detalle de la Reproducción</h2>

<div class="card">

<div class="card-header bg-success text-white">

Información del Servicio Reproductivo

</div>

<div class="card-body">

<table class="table table-bordered">

<tr>

<th width="250">Cerda</th>

<td>
{{ $reproduccion->hembra->codigo }}
-
{{ $reproduccion->hembra->raza }}
</td>

</tr>

<tr>

<th>Número de Servicio</th>

<td>{{ $reproduccion->numero_servicio }}</td>

</tr>

<tr>

<th>Tipo de Monta</th>

<td>{{ $reproduccion->tipo_monta }}</td>

</tr>

@if($reproduccion->tipo_monta=="Natural")

<tr>

<th>Macho</th>

<td>

## {{ $reproduccion->macho->codigo }}

{{ $reproduccion->macho->raza }}

</td>

</tr>

@else

<tr>

<th>Pajilla</th>

<td>

{{ $reproduccion->pajilla->codigo_pajilla }}

</td>

</tr>

@endif

<tr>

<th>Fecha de Celo</th>

<td>{{ $reproduccion->fecha_celo }}</td>

</tr>

<tr>

<th>Fecha de Servicio</th>

<td>{{ $reproduccion->fecha_servicio }}</td>

</tr>

<tr>

<th>Fecha Probable de Parto</th>

<td>{{ $reproduccion->fecha_probable_parto }}</td>

</tr>

<tr>

<th>Fecha de Parto</th>

<td>

{{ $reproduccion->fecha_parto ?? 'Pendiente' }}

</td>

</tr>

<tr>

<th>Crías Totales</th>

<td>

{{ $reproduccion->crias_totales ?? '---' }}

</td>

</tr>

<tr>

<th>Crías Vivas</th>

<td>

{{ $reproduccion->crias_vivas ?? '---' }}

</td>

</tr>

<tr>

<th>Crías Muertas</th>

<td>

{{ $reproduccion->crias_muertas ?? '---' }}

</td>

</tr>

<tr>

<th>Estado</th>

<td>

{{ $reproduccion->estado }}

</td>

</tr>

<tr>

<th>Observaciones</th>

<td>

{{ $reproduccion->observaciones ?? 'Sin observaciones.' }}

</td>

</tr>

</table>

<a href="{{ route('reproducciones.edit',$reproduccion->id) }}"
class="btn btn-warning">

Editar

</a>

<a href="{{ route('reproducciones.index') }}"
class="btn btn-secondary">

Volver

</a>

</div>

</div>

</div>

@endsection
