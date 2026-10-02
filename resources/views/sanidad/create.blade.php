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

        <option value="15d">
            Cada 15 días
        </option>

        <option value="3m">
            Cada 3 meses
        </option>

        <option value="6m">
            Cada 6 meses
        </option>

        <option value="12m">
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
        class="form-control"
        min="1">

</div>


<div class="mb-3">

    <label>Próxima Fecha</label>

    <input
        type="date"
        name="proxima_fecha"
        id="proxima_fecha"
        class="form-control">

    <small class="text-muted">
        La fecha se calcula automáticamente según la duración o frecuencia seleccionada,
        pero puede modificarse manualmente.
    </small>

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

const tipo = document.getElementById('tipo_registro');

const frecuencia = document.getElementById('div_frecuencia');

const duracion = document.getElementById('div_duracion');

const diagnostico = document.getElementById('div_diagnostico');

const fecha = document.getElementById('fecha');

const proxima = document.getElementById('proxima_fecha');

const dias = document.getElementById('duracion');

const meses = document.getElementById('frecuencia');


function actualizarFormulario() {

    frecuencia.style.display = 'none';

    duracion.style.display = 'none';

    diagnostico.style.display = 'none';


    if (
        tipo.value == 'Vacunacion' ||
        tipo.value == 'Desparasitacion/vitamina'
    ) {

        frecuencia.style.display = 'block';

    }


    if (
        tipo.value == 'Tratamiento' ||
        tipo.value == 'Control'
    ) {

        duracion.style.display = 'block';

        diagnostico.style.display = 'block';

    }

}


function calcularProximaFecha() {

    if (fecha.value == '') {
        return;
    }


    let f = new Date(fecha.value + 'T00:00:00');


    /*
    |--------------------------------------------------------------------------
    | TRATAMIENTO / CONTROL
    |--------------------------------------------------------------------------
    */

    if (
        (tipo.value == 'Tratamiento' ||
         tipo.value == 'Control') &&
        dias.value != ''
    ) {

        f.setDate(
            f.getDate() + parseInt(dias.value)
        );

        proxima.value =
            f.toISOString().split('T')[0];

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | VACUNACIÓN / DESPARASITACIÓN
    |--------------------------------------------------------------------------
    */

    if (
        (tipo.value == 'Vacunacion' ||
         tipo.value == 'Desparasitacion/vitamina') &&
        meses.value != ''
    ) {

        let valor = meses.value;


        if (valor == '15d') {

            f.setDate(
                f.getDate() + 15
            );

        }


        if (valor == '3m') {

            f.setMonth(
                f.getMonth() + 3
            );

        }


        if (valor == '6m') {

            f.setMonth(
                f.getMonth() + 6
            );

        }


        if (valor == '12m') {

            f.setFullYear(
                f.getFullYear() + 1
            );

        }


        proxima.value =
            f.toISOString().split('T')[0];

    }

}


tipo.addEventListener(
    'change',
    function() {

        actualizarFormulario();

        proxima.value = '';

    }
);


dias.addEventListener(
    'input',
    calcularProximaFecha
);


meses.addEventListener(
    'change',
    calcularProximaFecha
);


fecha.addEventListener(
    'change',
    calcularProximaFecha
);


actualizarFormulario();

</script>

@endsection