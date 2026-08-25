@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Nueva Reproducción</h2>

    @if ($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    @if(session('error'))

        <div class="alert alert-danger">

            {{ session('error') }}

        </div>

    @endif

    <form action="{{ route('reproducciones.store') }}" method="POST">

        @csrf

        <div class="row">

            <div class="col-md-6 mb-3">

                <label>Hembra Reproductora</label>

                <select name="hembra_id" class="form-control" required>

                    <option value="">Seleccione</option>

                    @foreach($hembras as $h)

                        <option value="{{ $h->id }}">

                            {{ $h->codigo }}

                            -

                            {{ $h->raza }}

                        </option>

                    @endforeach

                </select>

            </div>

            <div class="col-md-6 mb-3">

                <label>Tipo de Monta</label>

                <select
                    name="tipo_monta"
                    id="tipo_monta"
                    class="form-control"
                    required>

                    <option value="Natural">

                        Natural

                    </option>

                    <option value="Inseminacion">

                        Inseminación Artificial

                    </option>

                </select>

            </div>

        </div>


        <div class="row">

            <div class="col-md-6 mb-3" id="campo_macho">

                <label>Macho Reproductor</label>

                <select
                    name="macho_id"
                    class="form-control">

                    <option value="">Seleccione</option>

                    @foreach($machos as $m)

                        <option value="{{ $m->id }}">

                            {{ $m->codigo }}

                            -

                            {{ $m->raza }}

                        </option>

                    @endforeach

                </select>

            </div>


            <div
                class="col-md-6 mb-3"
                id="campo_pajilla"
                style="display:none;">

                <label>Pajilla</label>

                <select
                    name="pajilla_id"
                    class="form-control">

                    <option value="">Seleccione</option>

                    @foreach($pajillas as $p)

                        <option value="{{ $p->id }}">

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
                    id="fecha_celo"
                    class="form-control"
                    required>

            </div>

            <div class="col-md-4 mb-3">

                <label>Fecha de Servicio</label>

                <input
                    type="date"
                    name="fecha_servicio"
                    id="fecha_servicio"
                    class="form-control"
                    required>

            </div>

            <div class="col-md-4 mb-3">

                <label>Número de Servicio</label>

                <input
                    type="text"
                    class="form-control"
                    value="Automático"
                    readonly>

            </div>

        </div>


        <div class="row">

            <div class="col-md-6 mb-3">

                <label>Fecha Revisión de Celo</label>

                <input
                    type="date"
                    id="fecha_revision_celo"
                    class="form-control"
                    readonly>

            </div>

            <div class="col-md-6 mb-3">

                <label>Fecha Probable de Parto</label>

                <input
                    type="date"
                    id="fecha_probable_parto"
                    class="form-control"
                    readonly>

            </div>

        </div>


        <div class="mb-3">

            <label>Estado</label>

            <input
                type="text"
                class="form-control"
                value="Servida"
                readonly>

            <input
                type="hidden"
                name="estado"
                value="Servida">

        </div>


        <div class="mb-3">

            <label>Observaciones</label>

            <textarea
                name="observaciones"
                rows="4"
                class="form-control"></textarea>

        </div>


        <button
            class="btn btn-success">

            Guardar

        </button>

        <a
            href="{{ route('reproducciones.index') }}"
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

    function cambiarTipo(){

        if(tipo.value=="Natural"){

            macho.style.display="block";

            pajilla.style.display="none";

        }else{

            macho.style.display="none";

            pajilla.style.display="block";

        }

    }

    tipo.addEventListener("change",cambiarTipo);

    cambiarTipo();


    let servicio=document.getElementById("fecha_servicio");

    let revision=document.getElementById("fecha_revision_celo");

    let parto=document.getElementById("fecha_probable_parto");

    servicio.addEventListener("change",function(){

        if(this.value=="") return;

        let fecha=new Date(this.value);

        let celo=new Date(fecha);

        celo.setDate(celo.getDate()+21);

        let partoFecha=new Date(fecha);

        partoFecha.setDate(partoFecha.getDate()+114);

        revision.value=celo.toISOString().split('T')[0];

        parto.value=partoFecha.toISOString().split('T')[0];

    });

});

</script>

@endsection