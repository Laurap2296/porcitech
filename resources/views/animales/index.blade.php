@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Animales</h2>

        <a href="{{ route('animales.create') }}" class="btn btn-success">
            ➕ Nuevo Animal
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- FILTROS --}}
    <form method="GET" action="{{ route('animales.index') }}" class="mb-4">

        <div class="row g-3">

            <div class="col-md-2">
                <label for="codigo" class="form-label">
                    Código
                </label>

                <input
                    type="text"
                    name="codigo"
                    id="codigo"
                    class="form-control"
                    placeholder="Código"
                    value="{{ request('codigo') }}"
                >
            </div>

            <div class="col-md-2">
                <label for="sexo" class="form-label">
                    Sexo
                </label>

                <select name="sexo" id="sexo" class="form-select">
                    <option value="">Todos</option>

                    <option
                        value="Macho"
                        {{ request('sexo') == 'Macho' ? 'selected' : '' }}
                    >
                        Macho
                    </option>

                    <option
                        value="Hembra"
                        {{ request('sexo') == 'Hembra' ? 'selected' : '' }}
                    >
                        Hembra
                    </option>
                </select>
            </div>

            <div class="col-md-2">
                <label for="etapa" class="form-label">
                    Etapa
                </label>

                <select name="etapa" id="etapa" class="form-select">
                    <option value="">Todas</option>

                    <option
                        value="Lechon"
                        {{ request('etapa') == 'Lechon' ? 'selected' : '' }}
                    >
                        Lechón
                    </option>

                    <option
                        value="Levante"
                        {{ request('etapa') == 'Levante' ? 'selected' : '' }}
                    >
                        Levante
                    </option>

                    <option
                        value="Ceba"
                        {{ request('etapa') == 'Ceba' ? 'selected' : '' }}
                    >
                        Ceba
                    </option>

                    <option
                        value="Reproductor"
                        {{ request('etapa') == 'Reproductor' ? 'selected' : '' }}
                    >
                        Reproductor
                    </option>
                </select>
            </div>

            <div class="col-md-2">
                <label for="origen" class="form-label">
                    Origen
                </label>

                <select name="origen" id="origen" class="form-select">
                    <option value="">Todos</option>

                    <option
                        value="Nacido"
                        {{ request('origen') == 'Nacido' ? 'selected' : '' }}
                    >
                        Nacido
                    </option>

                    <option
                        value="Comprado"
                        {{ request('origen') == 'Comprado' ? 'selected' : '' }}
                    >
                        Comprado
                    </option>
                </select>
            </div>

            <div class="col-md-2">
                <label for="estado" class="form-label">
                    Estado
                </label>

                <select name="estado" id="estado" class="form-select">
                    <option value="">Todos</option>

                    <option
                        value="Activo"
                        {{ request('estado') == 'Activo' ? 'selected' : '' }}
                    >
                        Activo
                    </option>

                    <option
                        value="Vendido"
                        {{ request('estado') == 'Vendido' ? 'selected' : '' }}
                    >
                        Vendido
                    </option>

                    <option
                        value="Muerto"
                        {{ request('estado') == 'Muerto' ? 'selected' : '' }}
                    >
                        Muerto
                    </option>
                </select>
            </div>

            <div class="col-md-2">
                <label for="granja_id" class="form-label">
                    Granja
                </label>

                <select name="granja_id" id="granja_id" class="form-select">
                    <option value="">Todas</option>

                    @foreach($granjas as $granja)

                        <option
                            value="{{ $granja->id }}"
                            {{ request('granja_id') == $granja->id ? 'selected' : '' }}
                        >
                            {{ $granja->nombre }}
                        </option>

                    @endforeach

                </select>
            </div>

        </div>

        <div class="mt-3">

            <button type="submit" class="btn btn-primary">
                🔎 Filtrar
            </button>

            <a
                href="{{ route('animales.index') }}"
                class="btn btn-secondary"
            >
                Limpiar
            </a>

        </div>

    </form>

    {{-- TABLA --}}
    <div class="table-responsive">

        <table class="table table-bordered table-striped align-middle">

            <thead style="background-color: #198754; color: white;">

                <tr>
                    <th>Código</th>
                    <th>Raza</th>
                    <th>Sexo</th>
                    <th>Etapa</th>
                    <th>Origen</th>
                    <th>Estado</th>
                    <th>Granja</th>
                    <th>Acciones</th>
                </tr>

            </thead>

            <tbody>

                @forelse($animales as $animal)

                    <tr>

                        <td>
                            {{ $animal->codigo }}
                        </td>

                        <td>
                            {{ $animal->raza }}
                        </td>

                        <td>
                            {{ $animal->sexo }}
                        </td>

                        <td>
                            {{ $animal->etapa }}
                        </td>

                        <td>
                            {{ $animal->origen }}
                        </td>

                        <td>

                            @if($animal->estado === 'Activo')

                                <span class="badge bg-success">
                                    Activo
                                </span>

                            @elseif($animal->estado === 'Vendido')

                                <span class="badge bg-primary">
                                    Vendido
                                </span>

                            @elseif($animal->estado === 'Muerto')

                                <span class="badge bg-danger">
                                    Muerto
                                </span>

                            @else

                                <span class="badge bg-secondary">
                                    {{ $animal->estado }}
                                </span>

                            @endif

                        </td>

                        <td>
                            {{ $animal->granja->nombre ?? 'Sin granja' }}
                        </td>

                        <td>

                            <div class="d-flex gap-1">

                                {{-- VER HISTORIA --}}
                                <a
                                    href="{{ route('animales.show', $animal) }}"
                                    class="btn btn-sm btn-info"
                                    title="Ver historia"
                                >
                                    👁️
                                </a>

                                {{-- EDITAR --}}
                                <a
                                    href="{{ route('animales.edit', $animal) }}"
                                    class="btn btn-sm btn-warning"
                                    title="Editar"
                                >
                                    ✏️
                                </a>

                                {{-- ELIMINAR --}}
                                <form
                                    action="{{ route('animales.destroy', $animal) }}"
                                    method="POST"
                                    onsubmit="return confirm('¿Está seguro de eliminar este animal?')"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-danger"
                                        title="Eliminar"
                                    >
                                        🗑️
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="8"
                            class="text-center"
                        >
                            No hay animales registrados.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    {{-- PAGINACIÓN --}}
    @if($animales->hasPages())

        <div class="d-flex justify-content-center mt-3">

            {{ $animales->links() }}

        </div>

    @endif

</div>

@endsection