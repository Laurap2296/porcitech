@extends('layouts.app')

@section('content')

<h2>Registrar Granja</h2>

<form action="{{ route('granjas.store') }}" method="POST">

    @csrf

    <div class="mb-3">
        <label>Nombre</label>
        <input type="text" name="nombre" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Ubicación</label>
        <input type="text" name="ubicacion" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Propietario</label>
        <input type="text" name="propietario" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Teléfono</label>
        <input type="text" name="telefono" class="form-control">
    </div>

    <div class="mb-3">
        <label>Estado</label>

        <select name="estado" class="form-control">
            <option value="Activa">Activa</option>
            <option value="Inactiva">Inactiva</option>
        </select>
    </div>

    <button class="btn btn-success">
        Guardar
    </button>

    <a href="{{ route('granjas.index') }}" class="btn btn-secondary">
        Cancelar
    </a>

</form>

@endsection