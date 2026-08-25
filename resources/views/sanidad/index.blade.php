@extends('layouts.app')

@section('content')

<div class="container">

    

    <h4>Sanidad - Historial por Animal</h4>

    <a href="{{ route('sanidades.create') }}" class="btn btn-primary mb-3">
        Nuevo Registro Sanitario
    </a>

    @foreach($animales as $animal)

        @php
            $registros = $historial[$animal->id] ?? collect();
        @endphp

        <div class="card mb-4">

            <div class="card-header bg-success text-white">

                <strong>🐖 Animal {{ $animal->codigo }}</strong>

                @if($animal->raza)
                    | {{ $animal->raza }}
                @endif

                @if($animal->etapa)
                    | {{ $animal->etapa }}
                @endif

            </div>

            <div class="card-body">

                @if($registros->count() > 0)

                <table class="table table-bordered table-striped">

                    <thead>

                        <tr>

                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Nombre</th>
                            <th>Diagnóstico</th>
                            <th>Próxima Fecha</th>
                            <th width="220">Acciones</th>

                        </tr>

                    </thead>

                    <tbody>

                    @foreach($registros as $registro)

                        <tr>

                            <td>{{ $registro->fecha }}</td>

                            <td>{{ $registro->tipo_registro }}</td>

                            <td>{{ $registro->nombre }}</td>

                            <td>{{ $registro->diagnostico ?? '---' }}</td>

                            <td>{{ $registro->proxima_fecha ?? '---' }}</td>

                            <td>

                                <a href="{{ route('sanidades.show',$registro->id) }}"
                                   class="btn btn-info btn-sm">
                                    Ver
                                </a>

                                <a href="{{ route('sanidades.edit',$registro->id) }}"
                                   class="btn btn-warning btn-sm">
                                    Editar
                                </a>

                                <form action="{{ route('sanidades.destroy',$registro->id) }}"
                                      method="POST"
                                      style="display:inline;">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('¿Eliminar este registro?')">

                                        Eliminar

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @endforeach

                    </tbody>

                </table>

                @else

                    <div class="alert alert-secondary">

                        Este animal aún no tiene registros sanitarios.

                    </div>

                @endif

            </div>

        </div>

    @endforeach

</div>

@endsection