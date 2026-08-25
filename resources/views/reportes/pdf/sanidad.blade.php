<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>
        Reporte de Sanidad
    </title>

    <style>

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #333;
        }

        h1 {
            text-align: center;
            margin-bottom: 5px;
            color: #198754;
        }

        .subtitulo {
            text-align: center;
            margin-bottom: 20px;
            color: #666;
        }

        .resumen {
            width: 100%;
            margin-bottom: 15px;
        }

        .resumen td {
            width: 33.33%;
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        .resumen strong {
            display: block;
            font-size: 9px;
            margin-bottom: 4px;
        }

        .resumen span {
            font-size: 16px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #d1e7dd;
            border: 1px solid #999;
            padding: 7px;
            text-align: center;
        }

        td {
            border: 1px solid #999;
            padding: 6px;
            vertical-align: top;
        }

        .animal {
            width: 15%;
            text-align: center;
            font-weight: bold;
        }

        .historial {
            width: 85%;
        }

        .registro {
            border-bottom: 1px solid #ccc;
            padding: 6px 0;
            margin-bottom: 5px;
        }

        .registro:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .registro-tipo {
            font-weight: bold;
            color: #198754;
        }

        .campo {
            margin-right: 10px;
        }

        .label {
            font-weight: bold;
        }

        .filtros {
            margin-bottom: 15px;
            padding: 8px;
            border: 1px solid #ddd;
        }

        .filtros strong {
            color: #198754;
        }

        .pie {
            margin-top: 20px;
            text-align: center;
            font-size: 8px;
            color: #777;
        }

    </style>

</head>


<body>


    <h1>
        Reporte de Sanidad
    </h1>


    <div class="subtitulo">
        PorciTech - Sistema de Gestión y Control de Producción Porcina
    </div>



    {{-- ========================================================= --}}
    {{-- FILTROS APLICADOS --}}
    {{-- ========================================================= --}}

    <div class="filtros">

        <strong>Filtros aplicados:</strong>

        @if(request('animal_id'))

            Animal:
            {{ optional(\App\Models\Animal::find(request('animal_id')))->codigo }}

        @else

            Animal: Todos

        @endif


        &nbsp;&nbsp; | &nbsp;&nbsp;


        @if(request('tipo_registro'))

            Tipo:
            {{ request('tipo_registro') }}

        @else

            Tipo: Todos

        @endif


        &nbsp;&nbsp; | &nbsp;&nbsp;


        @if(request('fecha_desde'))

            Desde:
            {{ \Carbon\Carbon::parse(request('fecha_desde'))->format('d/m/Y') }}

        @else

            Desde: Todas

        @endif


        &nbsp;&nbsp; | &nbsp;&nbsp;


        @if(request('fecha_hasta'))

            Hasta:
            {{ \Carbon\Carbon::parse(request('fecha_hasta'))->format('d/m/Y') }}

        @else

            Hasta: Todas

        @endif

    </div>



    {{-- ========================================================= --}}
    {{-- RESUMEN --}}
    {{-- ========================================================= --}}

    <table class="resumen">

        <tr>

            <td>

                <strong>
                    Registros Sanitarios
                </strong>

                <span>
                    {{ $totalRegistros }}
                </span>

            </td>


            <td>

                <strong>
                    Animales Atendidos
                </strong>

                <span>
                    {{ $totalAnimales }}
                </span>

            </td>


            <td>

                <strong>
                    Próximos Controles
                </strong>

                <span>
                    {{ $proximosControles }}
                </span>

            </td>

        </tr>

    </table>



    {{-- ========================================================= --}}
    {{-- HISTORIAL SANITARIO --}}
    {{-- ========================================================= --}}

    <table>

        <thead>

            <tr>

                <th style="width: 8%;">
                    #
                </th>

                <th style="width: 17%;">
                    Animal
                </th>

                <th style="width: 75%;">
                    Historial sanitario
                </th>

            </tr>

        </thead>


        <tbody>


        @forelse($sanidadesAgrupadas as $animalId => $historial)


            @php

                $animal = $historial->first()->animal;

            @endphp


            <tr>


                {{-- NÚMERO --}}
                <td style="text-align: center;">

                    {{ $loop->iteration }}

                </td>


                {{-- ANIMAL --}}
                <td class="animal">

                    @if($animal)

                        {{ $animal->codigo }}

                        <br>

                        <small>
                            {{ $animal->sexo ?? '' }}
                        </small>

                        <br>

                        <small>
                            {{ $animal->etapa ?? '' }}
                        </small>

                    @else

                        Sin animal

                    @endif

                </td>


                {{-- HISTORIAL --}}
                <td class="historial">


                    @foreach($historial as $sanidad)

                        <div class="registro">


                            <div>

                                <span class="registro-tipo">

                                    {{ $sanidad->tipo_registro ?? 'Registro' }}

                                </span>

                                &nbsp; -

                                {{ $sanidad->nombre ?? 'N/A' }}

                            </div>


                            <div>

                                <span class="campo">

                                    <span class="label">
                                        Fecha:
                                    </span>

                                    @if($sanidad->fecha)

                                        {{ \Carbon\Carbon::parse($sanidad->fecha)->format('d/m/Y') }}

                                    @else

                                        N/A

                                    @endif

                                </span>


                                <span class="campo">

                                    <span class="label">
                                        Próximo control:
                                    </span>

                                    @if($sanidad->proxima_fecha)

                                        {{ \Carbon\Carbon::parse($sanidad->proxima_fecha)->format('d/m/Y') }}

                                    @else

                                        Sin fecha

                                    @endif

                                </span>

                            </div>


                            <div>

                                <span class="label">
                                    Diagnóstico:
                                </span>

                                {{ $sanidad->diagnostico ?? 'Sin diagnóstico' }}

                            </div>


                            <div>

                                <span class="label">
                                    Observaciones:
                                </span>

                                {{ $sanidad->observaciones ?? 'Sin observaciones' }}

                            </div>


                        </div>

                    @endforeach


                </td>

            </tr>


        @empty

            <tr>

                <td colspan="3"
                    style="text-align: center; padding: 15px;">

                    No existen registros sanitarios
                    para los filtros seleccionados.

                </td>

            </tr>

        @endforelse


        </tbody>

    </table>



    <div class="pie">

        Generado por PorciTech -
        {{ now()->format('d/m/Y H:i') }}

    </div>


</body>

</html>