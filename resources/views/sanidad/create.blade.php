@extends('layouts.app')

@section('content')

<div class="container">

<h2>Nuevo Registro Sanitario</h2>

<form action="{{ route('sanidades.store') }}" method="POST">

@csrf

<div class="mb-3">
    <label>Animal</label>

    <select name="animal_id" class="form-control" required>

        <option value="">Seleccione</option>

        @foreach($animales as $animal)

            <option value="{{ $animal->id }}">
                {{ $animal->codigo }} - {{ $animal->raza }}
            </option>

        @endforeach

    </select>

</div>

<div class="mb-3">

    <label>Tipo de Registro</label>

    <select
        name="tipo_registro"
        id="tipo_registro"
        class="form-control"
        required>

        <option value="">Seleccione</option>

        <option value="Vacunacion">
            Vacunación
        </option>

        <option value="Desparasitacion/vitamina">
            Desparasitación/vitamina
        </option>

        <option value="Tratamiento">
            Tratamiento
        </option>

        <option value="Control">
            Control
        </option>

    </select>

</div>

<div class="mb-3">

    <label>Nombre</label>

    <input
        type="text"
        name="nombre"
        id="nombre"
        class="form-control"
        required>

</div>

<div class="mb-3">

    <label>Fecha</label>

    <input
        type="date"
        name="fecha"
        id="fecha"
        class="form-control"
        required>

</div>

<div
    class="mb-3"
    id="div_frecuencia"
    style="display:none;">

    <label>Frecuencia</label>

    <select
        id="frecuencia"
        class="form-control">

        <option value="">Seleccione</option>

        <option value="3">
            Cada 3 meses
        </option>

        <option value="6">
            Cada 6 meses
        </option>

        <option value="12">
            Cada 1 año
        </option>

    </select>

</div>

<div
    class="mb-3"
    id="div_duracion"
    style="display:none;">

    <label>Duración (días)</label>

    <input
        type="number"
        id="duracion"
        class="form-control">

</div>

<div class="mb-3">

    <label>Próxima Fecha</label>

    <input
        type="date"
        name="proxima_fecha"
        id="proxima_fecha"
        class="form-control"
        readonly>

</div>

<div
    class="mb-3"
    id="div_diagnostico">

    <label>Diagnóstico</label>

    <textarea
        name="diagnostico"
        class="form-control"></textarea>

</div>

<div class="mb-3">

    <label>Observaciones</label>

    <textarea
        name="observaciones"
        class="form-control"></textarea>

</div>

<button class="btn btn-success">

    Guardar

</button>

<a href="{{ route('sanidades.index') }}"
class="btn btn-secondary">

Cancelar

</a>

</form>

</div>

<script>

const tipo=document.getElementById('tipo_registro');

const frecuencia=document.getElementById('div_frecuencia');

const duracion=document.getElementById('div_duracion');

const diagnostico=document.getElementById('div_diagnostico');

const fecha=document.getElementById('fecha');

const proxima=document.getElementById('proxima_fecha');

const dias=document.getElementById('duracion');

const meses=document.getElementById('frecuencia');

const nombre=document.getElementById('nombre');

function actualizarFormulario(){

frecuencia.style.display='none';

duracion.style.display='none';

diagnostico.style.display='none';

proxima.value='';

if(tipo.value=='Tratamiento'){

duracion.style.display='block';

diagnostico.style.display='block';

}

if(tipo.value=='Desparasitacion'){

frecuencia.style.display='block';

}

if(tipo.value=='Control'){

diagnostico.style.display='block';

}

if(tipo.value=='Vacunacion'){

if(nombre.value.toUpperCase()=='PPC'){

proxima.value='';

}

}

}

tipo.addEventListener('change',actualizarFormulario);

nombre.addEventListener('keyup',actualizarFormulario);

dias.addEventListener('keyup',function(){

if(fecha.value=='' || dias.value=='')

return;

let f=new Date(fecha.value);

f.setDate(f.getDate()+parseInt(dias.value));

proxima.value=f.toISOString().split('T')[0];

});

meses.addEventListener('change',function(){

if(fecha.value=='' || meses.value=='')

return;

let f=new Date(fecha.value);

f.setMonth(f.getMonth()+parseInt(meses.value));

proxima.value=f.toISOString().split('T')[0];

});

fecha.addEventListener('change',function(){

actualizarFormulario();

});

actualizarFormulario();

</script>

@endsection