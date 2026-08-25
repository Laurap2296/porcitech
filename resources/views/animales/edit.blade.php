@extends('layouts.app')

@section('content')

<h2>Editar Animal</h2>

<form action="{{ route('animales.update', $animale->id) }}" method="POST">

    @csrf
    @method('PUT')

    <div class="row">

        <div class="col-md-6 mb-3">
            <label>Código</label>
            <input type="text" name="codigo" class="form-control" value="{{ $animale->codigo }}">
        </div>

        <div class="col-md-6 mb-3">
            <label>Raza</label>
            <input type="text" name="raza" class="form-control" value="{{ $animale->raza }}">
        </div>

        <div class="col-md-6 mb-3">
            <label>Sexo</label>
            <select name="sexo" class="form-control">
                <option value="Macho" {{ $animale->sexo=='Macho'?'selected':'' }}>Macho</option>
                <option value="Hembra" {{ $animale->sexo=='Hembra'?'selected':'' }}>Hembra</option>
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label>Fecha Nacimiento</label>
            <input type="date" name="fecha_nacimiento" class="form-control" value="{{ $animale->fecha_nacimiento }}">
        </div>

        <div class="col-md-6 mb-3">
            <label>Peso Actual</label>
            <input type="number" step="0.01" name="peso_actual" class="form-control" value="{{ $animale->peso_actual }}">
        </div>

        <div class="col-md-6 mb-3">
            <label>Etapa</label>
            <select name="etapa" class="form-control">
                <option value="Lechon" {{ $animale->etapa=='Lechon'?'selected':'' }}>Lechón</option>
                <option value="Levante" {{ $animale->etapa=='Levante'?'selected':'' }}>Levante</option>
                <option value="Ceba" {{ $animale->etapa=='Ceba'?'selected':'' }}>Ceba</option>
                <option value="Reproductor" {{ $animale->etapa=='Reproductor'?'selected':'' }}>Reproductor</option>
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label>Origen</label>
            <select name="origen" class="form-control">
                <option value="Nacido" {{ $animale->origen=='Nacido'?'selected':'' }}>Nacido</option>
                <option value="Comprado" {{ $animale->origen=='Comprado'?'selected':'' }}>Comprado</option>
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label>Fecha Ingreso</label>
            <input type="date" name="fecha_ingreso" class="form-control" value="{{ $animale->fecha_ingreso }}">
        </div>

        <div class="col-md-6 mb-3">
            <label>Proveedor</label>
            <input type="text" name="proveedor" class="form-control" value="{{ $animale->proveedor }}">
        </div>

        <div class="col-md-6 mb-3">
            <label>Estado</label>
            <select name="estado" class="form-control">
                <option value="Activo" {{ $animale->estado=='Activo'?'selected':'' }}>Activo</option>
                <option value="Vendido" {{ $animale->estado=='Vendido'?'selected':'' }}>Vendido</option>
                <option value="Muerto" {{ $animale->estado=='Muerto'?'selected':'' }}>Muerto</option>
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label>Granja</label>
            <select name="granja_id" class="form-control">
                @foreach($granjas as $granja)
                    <option value="{{ $granja->id }}"
                        {{ $animale->granja_id==$granja->id?'selected':'' }}>
                        {{ $granja->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label>Madre ID</label>
            <input type="number" name="madre_id" class="form-control" value="{{ $animale->madre_id }}">
        </div>

        <div class="col-md-6 mb-3">
            <label>Padre ID</label>
            <input type="number" name="padre_id" class="form-control" value="{{ $animale->padre_id }}">
        </div>

        <div class="col-md-6 mb-3">
            <label>Código Genético</label>
            <input type="text" name="codigo_genetico" class="form-control" value="{{ $animale->codigo_genetico }}">
        </div>

        <div class="col-md-12 mb-3">
            <label>Observaciones</label>
            <textarea name="observaciones" class="form-control">{{ $animale->observaciones }}</textarea>
        </div>

    </div>

    <button class="btn btn-primary">
        Actualizar
    </button>

</form>

@endsection