<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>
        Análisis de Cerdas Reproductoras
    </title>

    <style>

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #222;
        }

        h1 {
            text-align: center;
            margin-bottom: 5px;
        }

        .fecha {
            text-align: right;
            font-size: 9px;
            margin-bottom: 15px;
        }

        .resumen {
            width: 100%;
            margin-bottom: 15px;
        }

        .resumen td {
            width: 25%;
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        .numero {
            font-size: 18px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #198754;
            color: white;
            padding: 7px;
            border: 1px solid #146c43;
            text-align: center;
        }

        td {
            padding: 6px;
            border: 1px solid #ccc;
            text-align: center;
        }

        .badge {
            font-weight: bold;
        }

        .sin-datos {
            text-align: center;
            padding: 20px;
        }

        .filtros {
            margin-bottom: 15px;
            font-size: 9px;
        }

    </style>

</head>


<body>


    <h1>
        Análisis de Cerdas Reproductoras
    </h1>


    <div class="fecha">

        Fecha de generación:
        {{ $fechaGeneracion }}

    </div>


    {{-- RESUMEN --}}

    <table class="resumen">

        <tr>

            <td>

                <strong>
                    Cerdas Evaluadas
                </strong>

                <div class="numero">
                    {{ $totalCerdas }}
                </div>

            </td>


            <td>

                <strong>
                    Total Servicios
                </strong>

                <div class="numero">
                    {{ $totalServicios }}
                </div>

            </td>


            <td>

                <strong>
                    Total Partos
                </strong>

                <div class="numero">
                    {{ $totalPartos }}
                </div>

            </td>


            <td>

                <strong>
                    Crías Vivas
                </strong>

                <div class="numero">
                    {{ $totalVivas }}
                </div>

            </td>

        </tr>

    </table>


    {{-- FILTROS APLICADOS --}}

    @if(
        request()->filled('hembra_id') ||
        request()->filled('fecha_desde') ||
        request()->filled('fecha_hasta')
    )

        <div class="filtros">

            <strong>
                Filtros aplicados:
            </strong>

            @if(request()->filled('fecha_desde'))

                Desde:
                {{ \Carbon\Carbon::parse(
                    request('fecha_desde')
                )->format('d/m/Y') }}

            @endif


            @if(request()->filled('fecha_hasta'))

                &nbsp;&nbsp;

                Hasta:
                {{ \Carbon\Carbon::parse(
                    request('fecha_hasta')
                )->format('d/m/Y') }}

            @endif


            @if(request()->filled('hembra_id'))

                &nbsp;&nbsp;

                Cerda ID:
                {{ request('hembra_id') }}

            @endif

        </div>

    @endif


    {{-- TABLA --}}

    <table>

        <thead>

            <tr>

                <th>
                    Ranking
                </th>

                <th>
                    Código Cerda
                </th>

                <th>
                    Raza
                </th>

                <th>
                    Servicios
                </th>

                <th>
                    Partos
                </th>

                <th>
                    Crías Totales
                </th>

                <th>
                    Crías Vivas
                </th>

                <th>
                    Crías Muertas
                </th>

                <th>
                    Promedio Crías Vivas
                </th>

                <th>
                    Productividad
                </th>

            </tr>

        </thead>


        <tbody>

        @forelse($cerdas as $cerda)

            <tr>

                <td>
                    #{{ $loop->iteration }}
                </td>

                <td>
                    {{ $cerda->codigo }}
                </td>

                <td>
                    {{ $cerda->raza ?? 'N/A' }}
                </td>

                <td>
                    {{ $cerda->servicios }}
                </td>

                <td>
                    {{ $cerda->partos }}
                </td>

                <td>
                    {{ $cerda->total_crias ?? 0 }}
                </td>

                <td>
                    {{ $cerda->vivas ?? 0 }}
                </td>

                <td>
                    {{ $cerda->muertas ?? 0 }}
                </td>

                <td>
                    {{ number_format(
                        $cerda->promedio ?? 0,
                        2
                    ) }}
                </td>

                <td>

                    @if($cerda->partos > 0)

                        {{ number_format(
                            $cerda->vivas /
                            $cerda->partos,
                            2
                        ) }}

                        crías/parto

                    @else

                        Sin partos

                    @endif

                </td>

            </tr>

        @empty

            <tr>

                <td
                    colspan="10"
                    class="sin-datos"
                >

                    No existen datos de análisis
                    reproductivo para los filtros seleccionados.

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>


</body>

</html>