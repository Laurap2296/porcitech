@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h2>Historial Reproductivo</h2>

        <a href="{{ route('reproducciones.create') }}"
           class="btn btn-success">

            Nueva Reproducción

        </a>

    </div>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    @if(session('error'))

        <div class="alert alert-danger">

            {{ session('error') }}

        </div>

    @endif


    @foreach($animales as $animal)

    <div class="card shadow mb-4">

        <div class="card-header bg-success text-white">

            <strong>

                {{ $animal->codigo }}

                |

                {{ $animal->raza }}

                |

                {{ $animal->etapa }}

            </strong>

        </div>

        <div class="card-body p-0">

            @if(isset($historial[$animal->id]))

            <table class="table table-bordered table-hover mb-0">

                <thead class="bg-white text-dark">

                    <tr>

                        <th>Fecha</th>

                        <th>Servicio</th>

                        <th>Tipo</th>

                        <th>Macho / Pajilla</th>

                        <th>Revisión Celo</th>

                        <th>Probable Parto</th>

                        <th>Estado</th>

                        <th width="220">Acciones</th>

                    </tr>

                </thead>

                <tbody>

                @foreach($historial[$animal->id] as $r)

                <tr>

                    <td>

                        {{ $r->fecha_servicio }}

                    </td>

                    <td>

                        {{ $r->numero_servicio }}

                    </td>

                    <td>

                        {{ $r->tipo_monta }}

                    </td>

                    <td>

                        @if($r->tipo_monta=="Natural")

                            {{ optional($r->macho)->codigo }}

                            -

                            {{ optional($r->macho)->raza }}

                        @else

                            {{ optional($r->pajilla)->codigo_pajilla }}

                        @endif

                    </td>

                    <td>

                        {{ $r->fecha_revision_celo }}

                    </td>

                    <td>

                        {{ $r->fecha_probable_parto }}

                    </td>

                    <td>

                        @if($r->estado=="Servida")

                            <span class="badge bg-primary">

                                Servida

                            </span>

                        @elseif($r->estado=="Gestante")

                            <span class="badge bg-success">

                                Gestante

                            </span>

                        @elseif($r->estado=="Parida")

                            <span class="badge bg-warning text-dark">

                                Parida

                            </span>

                        @elseif($r->estado=="Fallida")

                            <span class="badge bg-danger">

                                Fallida

                            </span>

                        @else

                            <span class="badge bg-secondary">

                                {{ $r->estado }}

                            </span>

                        @endif

                    </td>

                    <td>

                        <a href="{{ route('reproducciones.show',$r->id) }}"
                           class="btn btn-info btn-sm">

                            Ver

                        </a>

                        <a href="{{ route('reproducciones.edit',$r->id) }}"
                           class="btn btn-warning btn-sm">

                            Editar

                        </a>

                        <form action="{{ route('reproducciones.destroy',$r->id) }}"
                              method="POST"
                              style="display:inline">

                            @csrf
                            @method('DELETE')

                            <button
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('¿Eliminar registro?')">

                                Eliminar

                            </button>

                        </form>

                    </td>

                </tr>

                @endforeach

                </tbody>

            </table>

            @else

            <div class="p-3 text-center text-muted">

                Sin historial reproductivo.

            </div>

            @endif

        </div>

    </div>

    @endforeach

</div>

@endsection