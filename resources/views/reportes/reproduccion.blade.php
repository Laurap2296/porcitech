@extends('layouts.app')

@section('title', 'Reporte de Reproducción')

@section('content')

<div class="container-fluid">

    <div class="card shadow mb-4">

        <div class="card-header bg-success text-white">
            <h4 class="mb-0">
                <i class="bi bi-gender-male"></i>
                Reporte de Reproducción
            </h4>
        </div>

        <div class="card-body">

            {{-- ==========================================================
                 FILTROS
            =========================================================== --}}

            <form method="GET"
                  action="{{ route('reportes.reproduccion') }}"
                  class="mb-4">

                <div class="row g-3">

                    {{-- Hembra --}}
                    <div class="col-md-3">

                        <label class="form-label">
                            Hembra
                        </label>

                        <select name="hembra_id"
                                class="form-select">

                            <option value="">
                                Todas
                            </option>

                            @foreach($hembras as $hembra)

                                <option value="{{ $hembra->id }}"
                                    {{ request('hembra_id') == $hembra->id ? 'selected' : '' }}>

                                    {{ $hembra->codigo }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Macho --}}
                    <div class="col-md-3">

                        <label class="form-label">
                            Macho
                        </label>

                        <select name="macho_id"
                                class="form-select">

                            <option value="">
                                Todos
                            </option>

                            @foreach($machos as $macho)

                                <option value="{{ $macho->id }}"
                                    {{ request('macho_id') == $macho->id ? 'selected' : '' }}>

                                    {{ $macho->codigo }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Tipo de monta --}}
                    <div class="col-md-3">

                        <label class="form-label">
                            Tipo de monta
                        </label>

                        <select name="tipo_monta"
                                class="form-select">

                            <option value="">
                                Todos
                            </option>

                            <option value="Natural"
                                {{ request('tipo_monta') == 'Natural' ? 'selected' : '' }}>
                                Natural
                            </option>

                            <option value="Inseminación"
                                {{ request('tipo_monta') == 'Inseminación' ? 'selected' : '' }}>
                                Inseminación
                            </option>

                        </select>

                    </div>


                    {{-- Estado --}}
                    <div class="col-md-3">

                        <label class="form-label">
                            Estado
                        </label>

                        <select name="estado"
                                class="form-select">

                            <option value="">
                                Todos
                            </option>

                            <option value="En_Celo"
                                {{ request('estado') == 'En_Celo' ? 'selected' : '' }}>
                                En celo
                            </option>

                            <option value="Servida"
                                {{ request('estado') == 'Servida' ? 'selected' : '' }}>
                                Servida
                            </option>

                            <option value="Gestante"
                                {{ request('estado') == 'Gestante' ? 'selected' : '' }}>
                                Gestante
                            </option>

                            <option value="Parida"
                                {{ request('estado') == 'Parida' ? 'selected' : '' }}>
                                Parida
                            </option>

                            <option value="Fallida"
                                {{ request('estado') == 'Fallida' ? 'selected' : '' }}>
                                Fallida
                            </option>

                        </select>

                    </div>


                    {{-- Fecha desde --}}
                    <div class="col-md-3">

                        <label class="form-label">
                            Fecha desde
                        </label>

                        <input type="date"
                               name="fecha_desde"
                               value="{{ request('fecha_desde') }}"
                               class="form-control">

                    </div>


                    {{-- Fecha hasta --}}
                    <div class="col-md-3">

                        <label class="form-label">
                            Fecha hasta
                        </label>

                        <input type="date"
                               name="fecha_hasta"
                               value="{{ request('fecha_hasta') }}"
                               class="form-control">

                    </div>


                    {{-- Botones --}}
                    <div class="col-md-6 d-flex align-items-end gap-2">

                        <button type="submit"
                                class="btn btn-primary">

                            <i class="bi bi-funnel"></i>
                            Aplicar filtros

                        </button>


                        <a href="{{ route('reportes.reproduccion') }}"
                           class="btn btn-secondary">

                            <i class="bi bi-x-circle"></i>
                            Limpiar filtros

                        </a>


                        <a href="{{ route('reportes.index') }}"
                           class="btn btn-dark">

                            <i class="bi bi-arrow-left"></i>
                            Regresar a reportes

                        </a>

                    </div>

                </div>

            </form>


            {{-- ==========================================================
                 RESUMEN
            =========================================================== --}}

            <div class="row mb-4">

                <div class="col-md-3">

                    <div class="card bg-success text-white shadow">

                        <div class="card-body">

                            <h6>
                                Servicios
                            </h6>

                            <h2>
                                {{ $reproducciones->count() }}
                            </h2>

                        </div>

                    </div>

                </div>


                <div class="col-md-3">

                    <div class="card bg-primary text-white shadow">

                        <div class="card-body">

                            <h6>
                                Partos
                            </h6>

                            <h2>
                                {{ $reproducciones->whereNotNull('fecha_parto')->count() }}
                            </h2>

                        </div>

                    </div>

                </div>


                <div class="col-md-3">

                    <div class="card bg-warning text-dark shadow">

                        <div class="card-body">

                            <h6>
                                Crías Totales
                            </h6>

                            <h2>
                                {{ $reproducciones->sum('crias_totales') }}
                            </h2>

                        </div>

                    </div>

                </div>


                <div class="col-md-3">

                    <div class="card bg-danger text-white shadow">

                        <div class="card-body">

                            <h6>
                                Crías Vivas
                            </h6>

                            <h2>
                                {{ $reproducciones->sum('crias_vivas') }}
                            </h2>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ==========================================================
                 EXPORTAR
            =========================================================== --}}

            <div class="d-flex justify-content-end gap-2 mb-3">

                {{-- PDF conserva los filtros actuales --}}
                <a href="{{ route('reportes.reproduccion.pdf', request()->query()) }}"
                   class="btn btn-danger">

                    <i class="bi bi-file-earmark-pdf"></i>
                    PDF

                </a>

            </div>


            {{-- ==========================================================
                 TABLA
            =========================================================== --}}

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="table-success">

                        <tr>

                            <th>#</th>

                            <th>Hembra</th>

                            <th>Macho</th>

                            <th>Pajilla</th>

                            <th>Tipo Monta</th>

                            <th>Fecha Servicio</th>

                            <th>Parto</th>

                            <th>Crías</th>

                            <th>Estado</th>

                        </tr>

                    </thead>


                    <tbody>

                    @forelse($reproducciones as $reproduccion)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>


                            <td>

                                @if($reproduccion->hembra)

                                    {{ $reproduccion->hembra->codigo }}

                                @else

                                    Sin registro

                                @endif

                            </td>


                            <td>

                                @if($reproduccion->macho)

                                    {{ $reproduccion->macho->codigo }}

                                @else

                                    N/A

                                @endif

                            </td>


                            <td>

                                @if($reproduccion->pajilla)

                                    {{ $reproduccion->pajilla->codigo ?? 'Registrada' }}

                                @else

                                    N/A

                                @endif

                            </td>


                            <td>

                                @if($reproduccion->tipo_monta == 'Natural')

                                    <span class="badge bg-success">
                                        Natural
                                    </span>

                                @else

                                    <span class="badge bg-primary">
                                        Inseminación
                                    </span>

                                @endif

                            </td>


                            <td>

                                {{ $reproduccion->fecha_servicio
                                    ? \Carbon\Carbon::parse($reproduccion->fecha_servicio)->format('d/m/Y')
                                    : 'N/A'
                                }}

                            </td>


                            <td>

                                {{ $reproduccion->fecha_parto
                                    ? \Carbon\Carbon::parse($reproduccion->fecha_parto)->format('d/m/Y')
                                    : 'Pendiente'
                                }}

                            </td>


                            <td>

                                Total:
                                {{ $reproduccion->crias_totales ?? 0 }}

                                <br>

                                Vivas:
                                {{ $reproduccion->crias_vivas ?? 0 }}

                                <br>

                                Muertas:
                                {{ $reproduccion->crias_muertas ?? 0 }}

                            </td>


                            <td>

                                <span class="badge bg-info text-dark">

                                    {{ $reproduccion->estado }}

                                </span>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="9"
                                class="text-center">

                                No existen registros de reproducción
                                con los filtros seleccionados.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection