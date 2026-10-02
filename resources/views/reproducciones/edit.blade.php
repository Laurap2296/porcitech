@extends('layouts.app')

@section('content')

<div class="container">

<h2>Editar Reproducción</h2>

@if ($errors->any())

<div class="alert alert-danger">

<ul class="mb-0">

@foreach ($errors->all() as $error)

<li>{{ $error }}</li>

@endforeach

</ul>

</div>

@endif

<form action="{{ route('reproducciones.update',$reproduccion->id) }}" method="POST">

@csrf
@method('PUT')

<div class="row">

<div class="col-md-6 mb-3">

<label>Hembra Reproductora</label>

<select name="hembra_id" class="form-control" required>

@foreach($hembras as $h)

<option
value="{{ $h->id }}"
{{ $reproduccion->hembra_id==$h->id ? 'selected' : '' }}>

{{ $h->codigo }} - {{ $h->raza }}

</option>

@endforeach

</select>

</div>

<div class="col-md-6 mb-3">

<label>Tipo de Monta</label>

<select
name="tipo_monta"
id="tipo_monta"
class="form-control">

<option
value="Natural"
{{ $reproduccion->tipo_monta=='Natural' ? 'selected' : '' }}>

Natural

</option>

<option
value="Inseminacion"
{{ $reproduccion->tipo_monta=='Inseminacion' ? 'selected' : '' }}>

Inseminación Artificial

</option>

</select>

</div>

</div>


<div class="row">

<div
class="col-md-6 mb-3"
id="campo_macho">

<label>Macho Reproductor</label>

<select
name="macho_id"
class="form-control">

<option value="">Seleccione</option>

@foreach($machos as $m)

<option
value="{{ $m->id }}"
{{ $reproduccion->macho_id==$m->id ? 'selected' : '' }}>

{{ $m->codigo }}

-

{{ $m->raza }}

</option>

@endforeach

</select>

</div>

<div
class="col-md-6 mb-3"
id="campo_pajilla">

<label>Pajilla</label>

<select
name="pajilla_id"
class="form-control">

<option value="">Seleccione</option>

@foreach($pajillas as $p)

<option
value="{{ $p->id }}"
{{ $reproduccion->pajilla_id==$p->id ? 'selected' : '' }}>

{{ $p->codigo_pajilla }}

</option>

@endforeach

</select>

</div>

</div>


<div class="row">

<div class="col-md-4 mb-3">

<label>Fecha de Celo</label>

<input
type="date"
name="fecha_celo"
class="form-control"
value="{{ $reproduccion->fecha_celo }}">

</div>

<div class="col-md-4 mb-3">

<label>Fecha de Servicio</label>

<input
type="date"
name="fecha_servicio"
id="fecha_servicio"
class="form-control"
value="{{ $reproduccion->fecha_servicio }}">

</div>

<div class="col-md-4 mb-3">

<label>Número Servicio</label>

<input
type="text"
class="form-control"
value="{{ $reproduccion->numero_servicio }}"
readonly>

</div>

</div>


<div class="row">

<div class="col-md-6 mb-3">

<label>Fecha Revisión de Celo</label>

<input
type="date"
name="fecha_revision_celo"
id="fecha_revision_celo"
class="form-control"
value="{{ $reproduccion->fecha_revision_celo }}"
readonly>

</div>

<div class="col-md-6 mb-3">

<label>Fecha Probable de Parto</label>

<input
type="date"
name="fecha_probable_parto"
id="fecha_probable_parto"
class="form-control"
value="{{ $reproduccion->fecha_probable_parto }}"
readonly>

</div>

</div>

<div class="mb-3">

    <label>¿Repitió Celo?</label>

    <select name="repitio_celo" class="form-control">

        <option value="">Seleccione</option>

        <option value="Si"
            {{ $reproduccion->repitio_celo=='Si' ? 'selected' : '' }}>

            Sí

        </option>

        <option value="No"
            {{ $reproduccion->repitio_celo=='No' ? 'selected' : '' }}>

            No

        </option>

    </select>

</div>


<div class="row">

    <div class="col-md-4 mb-3">

        <label>Fecha de Parto</label>

        <input type="date"
               name="fecha_parto"
               class="form-control"
               value="{{ $reproduccion->fecha_parto }}">

    </div>

    <div class="col-md-4 mb-3">

        <label>Crías Totales</label>

        <input type="number"
               name="crias_totales"
               class="form-control"
               value="{{ $reproduccion->crias_totales }}">

    </div>

    <div class="col-md-4 mb-3">

        <label>Crías Vivas</label>

        <input type="number"
               name="crias_vivas"
               class="form-control"
               value="{{ $reproduccion->crias_vivas }}">

    </div>

</div>


<div class="row">

    <div class="col-md-4 mb-3">

        <label>Crías Muertas</label>

        <input type="number"
               name="crias_muertas"
               class="form-control"
               value="{{ $reproduccion->crias_muertas }}">

    </div>

    <div class="col-md-4 mb-3">

        <label>Estado</label>

        <select name="estado" class="form-control">

            <option value="Servida"
                {{ $reproduccion->estado=='Servida' ? 'selected' : '' }}>

                Servida

            </option>

            <option value="Gestante"
                {{ $reproduccion->estado=='Gestante' ? 'selected' : '' }}>

                Gestante

            </option>

            <option value="Parida"
                {{ $reproduccion->estado=='Parida' ? 'selected' : '' }}>

                Parida

            </option>

            <option value="Fallida"
                {{ $reproduccion->estado=='Fallida' ? 'selected' : '' }}>

                Fallida

            </option>

        </select>

    </div>

</div>


<div class="mb-3">

    <label>Observaciones</label>

    <textarea name="observaciones"
              class="form-control"
              rows="4">{{ $reproduccion->observaciones }}</textarea>

</div>


<button class="btn btn-primary">

    Actualizar

</button>

<a href="{{ route('reproducciones.index') }}"
   class="btn btn-secondary">

    Cancelar

</a>

</form>

</div>


<script>

document.addEventListener("DOMContentLoaded",function(){

    let tipo=document.getElementById("tipo_monta");
    let macho=document.getElementById("campo_macho");
    let pajilla=document.getElementById("campo_pajilla");

    function cambiar(){

        if(tipo.value=="Natural"){

            macho.style.display="block";
            pajilla.style.display="none";

        }else{

            macho.style.display="none";
            pajilla.style.display="block";

        }

    }

    tipo.addEventListener("change",cambiar);
    cambiar();


    /*--------------------------------------------------------------
    | CALCULAR FECHAS DE REVISIÓN Y PARTO
    |--------------------------------------------------------------*/

    let fechaServicio = document.getElementById("fecha_servicio");
    let fechaRevision = document.getElementById("fecha_revision_celo");
    let fechaParto = document.getElementById("fecha_probable_parto");

    function calcularFechas(){

        if(!fechaServicio.value){
            fechaRevision.value = "";
            fechaParto.value = "";
            return;
        }

        let fecha = new Date(fechaServicio.value + "T00:00:00");

        let revision = new Date(fecha);
        revision.setDate(revision.getDate() + 21);

        let parto = new Date(fecha);
        parto.setDate(parto.getDate() + 114);

        fechaRevision.value =
            revision.getFullYear() + "-" +
            String(revision.getMonth() + 1).padStart(2, "0") + "-" +
            String(revision.getDate()).padStart(2, "0");

        fechaParto.value =
            parto.getFullYear() + "-" +
            String(parto.getMonth() + 1).padStart(2, "0") + "-" +
            String(parto.getDate()).padStart(2, "0");
    }

    fechaServicio.addEventListener("change",calcularFechas);

    calcularFechas();

});

</script>

@endsection