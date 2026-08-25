<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>
        Reporte de Producción
    </title>

    <style>

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            color: #222;
        }

        h1 {
            text-align: center;
            color: #198754;
            margin-bottom: 5px;
        }

        h2 {
            text-align: center;
            margin-top: 0;
        }

        .fecha {
            text-align: center;
            margin-bottom: 15px;
        }

        .resumen {
            width: 100%;
            margin-bottom: 15px;
        }

        .resumen td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }

        .titulo {
            font-weight: bold;
            display: block;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #198754;
            color: white;
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        td {
            border: 1px solid #999;
            padding: 5px;
        }

        .center {
            text-align: center;
        }

        .filtros {
            margin-bottom: 15px;
            padding: 8px;
            border: 1px solid #ccc;
        }

        .muerto {
            font-weight: bold;
        }

        .vendido {
            font-weight: bold;
        }

        .rendimiento {
            font-weight: bold;
        }

    </style>

</head>


<body>

    <h1>
        PorciTech
    </h1>


    <h2>
        Reporte de Producción
    </h2>


    <div class="fecha">

        Fecha de generación:

        {{ now()->format('d/m/Y H:i') }}

    </div>


    {{-- ==========================================================
         FILTROS
    =========================================================== --}}

    @if(
        request('fecha_desde') ||
        request('fecha_hasta') ||
        request('tipo_registro') ||
        request('animal_id')
    )

        <div class="filtros">

            <strong>
                Filtros aplicados:
            </strong>


            @if(request('fecha_desde'))

                Desde:

                {{ \Carbon\Carbon::parse(
                    request('fecha_desde')
                )->format('d/m/Y') }}

            @endif


            @if(request('fecha_hasta'))

                &nbsp; | &nbsp;

                Hasta:

                {{ \Carbon\Carbon::parse(
                    request('fecha_hasta')
                )->format('d/m/Y') }}

            @endif


            @if(request('tipo_registro'))

                &nbsp; | &nbsp;

                Tipo:

                {{ ucfirst(
                    request('tipo_registro')
                ) }}

            @endif


            @if(request('animal_id'))

                &nbsp; | &nbsp;

                Animal:

                {{ request('animal_id') }}

            @endif

        </div>

    @endif


    {{-- ==========================================================
         RESUMEN
    =========================================================== --}}

    <table class="resumen">

        <tr>

            <td>

                <span class="titulo">
                    Registros
                </span>

                {{ $producciones->count() }}

            </td>


            <td>

                <span class="titulo">
                    Animales evaluados
                </span>

                {{ $producciones
                    ->pluck('animal_id')
                    ->unique()
                    ->count()
                }}

            </td>


            <td>

                <span class="titulo">
                    Peso promedio vivo
                </span>

                {{ number_format(
                    $producciones->avg('peso_vivo'),
                    2
                ) }}

                Kg

            </td>


            <td>

                <span class="titulo">
                    Rendimiento promedio
                </span>

                {{ number_format(
                    $producciones->avg('rendimiento'),
                    2
                ) }}

                %

            </td>

        </tr>

    </table>


    {{-- ==========================================================
         TABLA PRINCIPAL
    =========================================================== --}}

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
                    Estado
                </th>

                <th>
                    Fecha
                </th>

                <th>
                    Tipo
                </th>

                <th>
                    Peso Vivo
                </th>

                <th>
                    Peso Canal
                </th>

                <th>
                    Rendimiento
                </th>

                <th>
                    Observaciones
                </th>

            </tr>

        </thead>


        <tbody>

            @forelse($producciones as $produccion)

                <tr>

                    {{-- # --}}

                    <td class="center">
                        {{ $loop->iteration }}
                    </td>


                    {{-- ANIMAL --}}

                    <td>

                        @if($produccion->animal)

                            {{ $produccion->animal->codigo }}

                        @else

                            Sin animal

                        @endif

                    </td>


                    {{-- ESTADO --}}

                    <td class="center">

                        @if($produccion->animal)

                            @if(
                                $produccion->animal->estado === 'Muerto'
                            )

                                <span class="muerto">
                                    MUERTO
                                </span>

                            @elseif(
                                $produccion->animal->estado === 'Vendido'
                            )

                                <span class="vendido">
                                    VENDIDO
                                </span>

                            @else

                                {{ $produccion->animal->estado }}

                            @endif

                        @else

                            Sin animal

                        @endif

                    </td>


                    {{-- FECHA --}}

                    <td>

                        {{ \Carbon\Carbon::parse(
                            $produccion->fecha
                        )->format('d/m/Y') }}

                    </td>


                    {{-- TIPO --}}

                    <td>

                        {{ ucfirst(
                            $produccion->tipo_registro
                        ) }}

                    </td>


                    {{-- PESO VIVO --}}

                    <td>

                        {{ number_format(
                            $produccion->peso_vivo,
                            2
                        ) }}

                        Kg

                    </td>


                    {{-- PESO CANAL --}}

                    <td>

                        @if(
                            $produccion->peso_canal !== null
                        )

                            {{ number_format(
                                $produccion->peso_canal,
                                2
                            ) }}

                            Kg

                        @else

                            N/A

                        @endif

                    </td>


                    {{-- RENDIMIENTO --}}

                    <td class="center">

                        @if(
                            $produccion->rendimiento !== null
                        )

                            <span class="rendimiento">

                                {{ number_format(
                                    $produccion->rendimiento,
                                    2
                                ) }}

                                %

                            </span>

                        @else

                            N/A

                        @endif

                    </td>


                    {{-- OBSERVACIONES --}}

                    <td>

                        {{ $produccion->observaciones
                            ?? 'Sin observaciones'
                        }}

                    </td>

                </tr>

            @empty

                <tr>

                    <td
                        colspan="9"
                        class="center"
                    >

                        No existen registros
                        de producción.

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</body>

</html>