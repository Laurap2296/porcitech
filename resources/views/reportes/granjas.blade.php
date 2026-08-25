@extends('layouts.app')

@section('title', 'Reporte de Granjas')

@section('content')

<div class="container-fluid">

    <div class="card shadow mb-4">

        {{-- ENCABEZADO --}}
        <div class="card-header bg-success text-white">

            <div class="d-flex justify-content-between align-items-center">

                <h4 class="mb-0">
                    <i class="bi bi-house-door"></i>
                    Reporte de Granjas
                </h4>

                {{-- BOTÓN VOLVER --}}
                <a href="{{ route('reportes.index') }}"
                   class="btn btn-light">

                    <i class="bi bi-arrow-left"></i>
                    Volver a Reportes

                </a>

            </div>

        </div>


        <div class="card-body">


            {{-- ==========================================================
                 RESUMEN
            =========================================================== --}}

            <div class="row mb-4">

                {{-- TOTAL --}}
                <div class="col-md-4">

                    <div class="card bg-success text-white shadow">

                        <div class="card-body">

                            <h6>
                                Total de Granjas
                            </h6>

                            <h2>
                                {{ $granjas->count() }}
                            </h2>

                        </div>

                    </div>

                </div>


                {{-- ACTIVAS --}}
                <div class="col-md-4">

                    <div class="card bg-primary text-white shadow">

                        <div class="card-body">

                            <h6>
                                Granjas Activas
                            </h6>

                            <h2>
                                {{ $granjas->where('estado', 'activa')->count() }}
                            </h2>

                        </div>

                    </div>

                </div>


                {{-- INACTIVAS --}}
                <div class="col-md-4">

                    <div class="card bg-secondary text-white shadow">

                        <div class="card-body">

                            <h6>
                                Granjas Inactivas
                            </h6>

                            <h2>
                                {{ $granjas->where('estado', 'inactiva')->count() }}
                            </h2>

                        </div>

                    </div>

                </div>

            </div>



            {{-- ==========================================================
                 FILTROS
            =========================================================== --}}

            <div class="card shadow-sm border-success mb-4">

                <div class="card-header bg-light">

                    <h5 class="mb-0 text-success">

                        <i class="bi bi-funnel"></i>
                        Filtrar reporte

                    </h5>

                </div>


                <div class="card-body">

                    <form method="GET"
                          action="{{ route('reportes.granjas') }}">

                        <div class="row">


                            {{-- ESTADO --}}

                            <div class="col-md-4 mb-3">

                                <label class="form-label fw-bold">

                                    Estado de la granja

                                </label>


                                <select name="estado"
                                        class="form-select">

                                    <option value="todos"
                                        {{ $estado == 'todos' ? 'selected' : '' }}>

                                        Todas las granjas

                                    </option>


                                    <option value="activa"
                                        {{ $estado == 'activa' ? 'selected' : '' }}>

                                        Activas

                                    </option>


                                    <option value="inactiva"
                                        {{ $estado == 'inactiva' ? 'selected' : '' }}>

                                        Inactivas

                                    </option>

                                </select>

                            </div>


                            {{-- BOTONES --}}

                            <div class="col-md-8 mb-3 d-flex align-items-end gap-2">

                                <button type="submit"
                                        class="btn btn-success">

                                    <i class="bi bi-search"></i>
                                    Aplicar filtro

                                </button>


                                <a href="{{ route('reportes.granjas') }}"
                                   class="btn btn-secondary">

                                    <i class="bi bi-x-circle"></i>
                                    Limpiar filtro

                                </a>

                            </div>

                        </div>

                    </form>

                </div>

            </div>



            {{-- ==========================================================
                 FILTRO ACTUAL
            =========================================================== --}}

            @if($estado != 'todos')

                <div class="alert alert-info">

                    <i class="bi bi-info-circle"></i>

                    <strong>Filtro aplicado:</strong>

                    Estado:

                    <strong>
                        {{ ucfirst($estado) }}
                    </strong>

                </div>

            @endif



            {{-- ==========================================================
                 BOTONES EXPORTACIÓN
            =========================================================== --}}

            <div class="d-flex justify-content-between align-items-center mb-3">


                {{-- VOLVER --}}

                <a href="{{ route('reportes.index') }}"
                   class="btn btn-secondary">

                    <i class="bi bi-arrow-left"></i>

                    Volver a reportes

                </a>


                <div>

                    {{-- PDF --}}

                    <a href="{{ route('reportes.granjas.pdf', request()->query()) }}"
                       class="btn btn-danger">

                        <i class="bi bi-file-earmark-pdf"></i>

                        Exportar PDF

                    </a>

                </div>

            </div>



            {{-- ==========================================================
                 TABLA
            =========================================================== --}}

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="table-success">

                        <tr>

                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Ubicación</th>
                            <th>Propietario</th>
                            <th>Teléfono</th>
                            <th>Estado</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($granjas as $granja)

                            <tr>

                                <td>
                                    {{ $granja->id }}
                                </td>


                                <td>
                                    {{ $granja->nombre }}
                                </td>


                                <td>
                                    {{ $granja->ubicacion }}
                                </td>


                                <td>
                                    {{ $granja->propietario }}
                                </td>


                                <td>
                                    {{ $granja->telefono ?? 'No registrado' }}
                                </td>


                                <td>

                                    @if($granja->estado == 'activa')

                                        <span class="badge bg-success">
                                            Activa
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            Inactiva
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6"
                                    class="text-center py-4">

                                    <i class="bi bi-search"
                                       style="font-size: 35px;">
                                    </i>

                                    <p class="mt-2 mb-0">

                                        No existen granjas
                                        con el filtro seleccionado.

                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>



            {{-- TOTAL MOSTRADO --}}

            <div class="text-end mt-3">

                <strong>

                    Registros mostrados:
                    {{ $granjas->count() }}

                </strong>

            </div>


        </div>

    </div>

</div>

@endsection