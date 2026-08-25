@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">

    <h2>Animales</h2>

    <a href="{{ route('animales.create') }}"
       class="btn btn-success">
        Nuevo Animal
    </a>

</div>


@if(session('success'))

    <div class="alert alert-success">
        {{ session('success') }}
    </div>

@endif


<div class="table-responsive">

    <table class="table table-bordered table-striped align-middle">

        <thead>

            <tr>

                <th>Código</th>
                <th>Raza</th>
                <th>Sexo</th>
                <th>Etapa</th>
                <th>Origen</th>
                <th>Estado</th>
                <th>Granja</th>
                <th class="text-center">Acciones</th>

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


                {{-- ================================================= --}}
                {{-- ACCIONES --}}
                {{-- ================================================= --}}

                <td class="text-center">

                    <div class="d-flex justify-content-center gap-1">

                        {{-- VER HISTORIA --}}
                        <a href="{{ route('animales.show', $animal->id) }}"
                           class="btn btn-info btn-sm"
                           title="Ver historia clínica y productiva"
                           aria-label="Ver historia clínica y productiva">

                            👁️

                        </a>


                        {{-- EDITAR --}}
                        <a href="{{ route('animales.edit', $animal->id) }}"
                           class="btn btn-warning btn-sm"
                           title="Editar animal"
                           aria-label="Editar animal">

                            ✏️

                        </a>


                        {{-- ELIMINAR --}}
                        <form action="{{ route('animales.destroy', $animal->id) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('¿Está seguro de eliminar este animal?');">

                            @csrf

                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-danger btn-sm"
                                    title="Eliminar animal"
                                    aria-label="Eliminar animal">

                                🗑️

                            </button>

                        </form>

                    </div>

                </td>

            </tr>

        @empty

            <tr>

                <td colspan="8" class="text-center">

                    No hay animales registrados

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection