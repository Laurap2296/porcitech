<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>
        Reporte de Alimentación
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

        .subtitulo {
            text-align: center;
            margin-bottom: 15px;
            color: #555;
        }

        .resumen {
            width: 100%;
            margin-bottom: 15px;
        }

        .resumen td {
            width: 33.33%;
            padding: 8px;
            text-align: center;
            border: 1px solid #ccc;
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
            padding: 6px;
            border: 1px solid #555;
            text-align: center;
        }

        td {
            padding: 5px;
            border: 1px solid #999;
            text-align: center;
        }

        .texto-izquierda {
            text-align: left;
        }

        .automatica {
            font-weight: bold;
        }

        .ajustada {
            font-weight: bold;
        }

        .sin-racion {
            color: #b02a37;
            font-weight: bold;
        }

        .nota {
            margin-top: 15px;
            padding: 8px;
            border: 1px solid #ccc;
            background-color: #f5f5f5;
        }

        .pie {
            margin-top: 15px;
            font-size: 8px;
            text-align: right;
            color: #666;
        }

    </style>

</head>


<body>


    {{-- ========================================================= --}}
    {{-- ENCABEZADO --}}
    {{-- ========================================================= --}}

    <h1>
        PorciTech
    </h1>

    <h2 style="text-align:center;">
        Reporte de Alimentación
    </h2>

    <div class="subtitulo">

        Planilla de ración recomendada y ajustada

    </div>


    {{-- ========================================================= --}}
    {{-- RESUMEN --}}
    {{-- ========================================================= --}}

    <table class="resumen">

        <tr>

            <td>

                <div>
                    Animales
                </div>

                <div class="numero">
                    {{ $totalAnimales }}
                </div>

            </td>


            <td>

                <div>
                    Automáticas
                </div>

                <div class="numero">
                    {{ $totalAutomaticas }}
                </div>

            </td>


            <td>

                <div>
                    Ajustadas
                </div>

                <div class="numero">
                    {{ $totalAjustadas }}
                </div>

            </td>

        </tr>

    </table>


    {{-- ========================================================= --}}
    {{-- TABLA --}}
    {{-- ========================================================= --}}

    <table>

        <thead>

            <tr>

                <th>
                    #
                </th>

                <th>
                    Animal
                </th>

                <th>
                    Sexo
                </th>

                <th>
                    Etapa
                </th>

                <th>
                    Peso
                </th>

                <th>
                    Condición
                </th>

                <th>
                    Gestación
                </th>

                <th>
                    Ración
                </th>

                <th>
                    Cantidad
                </th>

                <th>
                    Tipo
                </th>

                <th>
                    Observación
                </th>

            </tr>

        </thead>


        <tbody>

        @forelse($animales as $animal)

            <tr>

                {{-- # --}}
                <td>

                    {{ $loop->iteration }}

                </td>


                {{-- ANIMAL --}}
                <td>

                    <strong>

                        {{ $animal->codigo }}

                    </strong>

                </td>


                {{-- SEXO --}}
                <td>

                    {{ $animal->sexo }}

                </td>


                {{-- ETAPA --}}
                <td>

                    {{ $animal->etapa }}

                </td>


                {{-- PESO --}}
                <td>

                    {{ number_format(
                        $animal->peso_actual,
                        2
                    ) }}

                    Kg

                </td>


                {{-- CONDICIÓN --}}
                <td>

                    {{ $animal->condicion_reproductiva ?? 'No aplica' }}

                </td>


                {{-- GESTACIÓN --}}
                <td>

                    @if($animal->dias_gestacion)

                        {{ $animal->dias_gestacion }}
                        días

                    @else

                        —

                    @endif

                </td>


                {{-- RACIÓN --}}
                <td>

                    @if($animal->racion_recomendada)

                        @php

                            $nombreRacion =
                                $animal->racion_recomendada->tipo_alimento
                                ?? $animal->racion_recomendada->alimento
                                ?? $animal->racion_recomendada->nombre
                                ?? null;

                        @endphp

                        {{ $nombreRacion ?? 'Según etapa y condición' }}

                    @else

                        <span class="sin-racion">

                            Sin configurar

                        </span>

                    @endif

                </td>


                {{-- CANTIDAD --}}
                <td>

                    @if($animal->cantidad_mostrar !== null)

                        <strong>

                            {{ number_format(
                                $animal->cantidad_mostrar,
                                2
                            ) }}

                            Kg

                        </strong>

                    @else

                        —

                    @endif

                </td>


                {{-- TIPO --}}
                <td>

                    {{ $animal->tipo_cantidad }}

                </td>


                {{-- OBSERVACIÓN --}}
                <td class="texto-izquierda">

                    {{ $animal->observacion_reporte ?? '—' }}

                </td>

            </tr>

        @empty

            <tr>

                <td colspan="11">

                    No existen animales para mostrar.

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>


    {{-- ========================================================= --}}
    {{-- NOTA --}}
    {{-- ========================================================= --}}

    <div class="nota">

        <strong>
            Nota:
        </strong>

        La cantidad automática se calcula de acuerdo con la etapa,
        sexo, peso y condición reproductiva del animal.
        Cuando existe un ajuste manual registrado, se utiliza la
        cantidad ajustada y se muestra como tal.

    </div>


    {{-- ========================================================= --}}
    {{-- PIE --}}
    {{-- ========================================================= --}}

    <div class="pie">

        Generado por PorciTech -
        {{ now()->format('d/m/Y H:i') }}

    </div>


</body>

</html>