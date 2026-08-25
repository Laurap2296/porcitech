@extends('layouts.app')

@section('content')

<h2>Registrar Animal</h2>

<form action="{{ route('animales.store') }}" method="POST">

    @csrf

    <div class="row">

        <div class="col-md-6 mb-3">
            <label>Código</label>
            <input type="text"
                   name="codigo"
                   class="form-control"
                   required>
        </div>

        <div class="col-md-6 mb-3">
            <label>Raza</label>
            <input type="text"
                   name="raza"
                   class="form-control"
                   required>
        </div>

        <div class="col-md-6 mb-3">
            <label>Sexo</label>

            <select name="sexo" class="form-control">
                <option value="Macho">Macho</option>
                <option value="Hembra">Hembra</option>
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label>Fecha Nacimiento</label>
            <input type="date"
                   name="fecha_nacimiento"
                   class="form-control"
                   required>
        </div>

        <div class="col-md-6 mb-3">
            <label>Peso Actual (Kg)</label>
            <input type="number"
                   step="0.01"
                   name="peso_actual"
                   class="form-control"
                   required>
        </div>

        <div class="col-md-6 mb-3">
            <label>Etapa</label>

            <select name="etapa" class="form-control">
                <option value="Lechon">Lechón</option>
                <option value="Levante">Levante</option>
                <option value="Ceba">Ceba</option>
                <option value="Reproductor">Reproductor</option>
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label>Origen</label>

            <select name="origen"
                    id="origen"
                    class="form-control">

                <option value="Nacido">Nacido</option>
                <option value="Comprado">Comprado</option>

            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label>Estado</label>

            <select name="estado" class="form-control">
                <option value="Activo">Activo</option>
                <option value="Vendido">Vendido</option>
                <option value="Muerto">Muerto</option>
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label>Granja</label>

            <select name="granja_id"
                    class="form-control"
                    required>

                <option value="">Seleccione una granja</option>

                @foreach($granjas as $granja)

                    <option value="{{ $granja->id }}">
                        {{ $granja->nombre }}
                    </option>

                @endforeach

            </select>
        </div>

        <!-- DATOS DE COMPRA -->

        <div id="datosCompra" class="row">

            <div class="col-md-6 mb-3">
                <label>Fecha Ingreso</label>

                <input type="date"
                       name="fecha_ingreso"
                       class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>Proveedor</label>

                <input type="text"
                       name="proveedor"
                       class="form-control">
            </div>

        </div>

        <!-- DATOS DE NACIMIENTO -->

        <div id="datosNacimiento" class="row">

            <div class="col-md-6 mb-3">
                <label>Madre</label>

                <select name="madre_id" class="form-control">

                    <option value="">Seleccione</option>

                    @foreach($madres as $madre)

                        <option value="{{ $madre->id }}">
                            {{ $madre->codigo }}
                        </option>

                    @endforeach

                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label>Padre</label>

                <select name="padre_id" class="form-control">

                    <option value="">Seleccione</option>

                    @foreach($padres as $padre)

                        <option value="{{ $padre->id }}">
                            {{ $padre->codigo }}
                        </option>

                    @endforeach

                </select>
            </div>

        </div>

        <div class="col-md-12 mb-3">
            <label>Observaciones</label>

            <textarea name="observaciones"
                      class="form-control"
                      rows="4"></textarea>
        </div>

    </div>

    <button type="submit" class="btn btn-success">
        Guardar Animal
    </button>

    <a href="{{ route('animales.index') }}"
       class="btn btn-secondary">
       Cancelar
    </a>

</form>

<script>

function cambiarOrigen()
{
    let origen = document.getElementById('origen').value;

    if(origen === 'Comprado')
    {
        document.getElementById('datosCompra').style.display = 'flex';
        document.getElementById('datosNacimiento').style.display = 'none';
    }
    else
    {
        document.getElementById('datosCompra').style.display = 'none';
        document.getElementById('datosNacimiento').style.display = 'flex';
    }
}

document.addEventListener('DOMContentLoaded', function(){

    cambiarOrigen();

    document.getElementById('origen')
        .addEventListener('change', cambiarOrigen);

});

</script>

@endsection