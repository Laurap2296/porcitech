@extends('layouts.app')

@section('content')

<h2>Editar Granja</h2>

<form action="{{ route('granjas.update', $granja->id) }}" method="POST">

    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Nombre</label>
        <input type="text"
               name="nombre"
               class="form-control"
               value="{{ $granja->nombre }}">
    </div>

    <div class="mb-3">
        <label>Ubicación</label>
        <input type="text"
               name="ubicacion"
               class="form-control"
               value="{{ $granja->ubicacion }}">
    </div>

    <div class="mb-3">
        <label>Propietario</label>
        <input type="text"
               name="propietario"
               class="form-control"
               value="{{ $granja->propietario }}">
    </div>

    <div class="mb-3">
        <label>Teléfono</label>
        <input type="text"
               name="telefono"
               class="form-control"
               value="{{ $granja->telefono }}">
    </div>

    <div class="mb-3">

        <label>Estado</label>

        <select name="estado" class="form-control">

            <option value="Activa"
                {{ $granja->estado == 'Activa' ? 'selected' : '' }}>
                Activa
            </option>

            <option value="Inactiva"
                {{ $granja->estado == 'Inactiva' ? 'selected' : '' }}>
                Inactiva
            </option>

        </select>

    </div>

    <button class="btn btn-primary">
        Actualizar
    </button>

</form>

@endsection