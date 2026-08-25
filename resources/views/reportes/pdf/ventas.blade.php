<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>
        Reporte de Ventas - PorciTech
    </title>

    <style>

        @page {
            margin: 35px 30px 35px 30px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #222;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
            color: #198754;
        }

        .header h2 {
            margin: 5px 0 0 0;
            font-size: 16px;
        }

        .fecha {
            margin-top: 6px;
            font-size: 9px;
            color: #666;
        }

        .resumen {
            width: 100%;
            margin-bottom: 18px;
        }

        .resumen td {
            width: 33.33%;
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        .resumen strong {
            display: block;
            font-size: 11px;
            margin-bottom: 5px;
        }

        .resumen span {
            display: block;
            font-size: 16px;
            font-weight: bold;
        }

        .tabla {
            width: 100%;
            border-collapse: collapse;
        }

        .tabla th {
            background-color: #198754;
            color: white;
            border: 1px solid #146c43;
            padding: 7px 5px;
            text-align: center;
            font-size: 9px;
        }

        .tabla td {
            border: 1px solid #ccc;
            padding: 6px 5px;
            font-size: 9px;
        }

        .tabla td.center {
            text-align: center;
        }

        .tabla td.money {
            text-align: right;
        }

        .tabla tr:nth-child(even) {
            background-color: #f5f5f5;
        }

        .sin-registros {
            text-align: center;
            padding: 20px;
            font-weight: bold;
        }

        .filtros {
            margin-bottom: 15px;
            font-size: 9px;
        }

        .filtros strong {
            color: #198754;
        }

        .footer {
            position: fixed;
            bottom: -20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8px;
            color: #777;
        }

    </style>

</head>


<body>


    {{-- ENCABEZADO --}}
    <div class="header">

        <h1>
            PorciTech
        </h1>

        <h2>
            Reporte de Ventas
        </h2>

        <div class="fecha">

            Fecha de generación:
            {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}

        </div>

    </div>


    {{-- FILTROS APLICADOS --}}
    @if(
        request()->filled('animal_id') ||
        request()->filled('fecha_desde') ||
        request()->filled('fecha_hasta')
    )

        <div class="filtros">

            <strong>Filtros aplicados:</strong>

            @if(request()->filled('animal_id'))

                Animal:
                @php
                    $animalFiltro = \App\Models\Animal::find(
                        request('animal_id')
                    );
                @endphp

                {{ $animalFiltro?->codigo ?? 'N/A' }}

            @endif


            @if(request()->filled('fecha_desde'))

                &nbsp; | &nbsp;

                Desde:
                {{ \Carbon\Carbon::parse(
                    request('fecha_desde')
                )->format('d/m/Y') }}

            @endif


            @if(request()->filled('fecha_hasta'))

                &nbsp; | &nbsp;

                Hasta:
                {{ \Carbon\Carbon::parse(
                    request('fecha_hasta')
                )->format('d/m/Y') }}

            @endif

        </div>

    @endif


    {{-- RESUMEN --}}
    <table class="resumen">

        <tr>

            <td>

                <strong>
                    Total Ventas
                </strong>

                <span>
                    {{ $ventas->count() }}
                </span>

            </td>


            <td>

                <strong>
                    Animales Vendidos
                </strong>

                <span>

                    {{ $ventas
                        ->pluck('animal_id')
                        ->unique()
                        ->count()
                    }}

                </span>

            </td>


            <td>

                <strong>
                    Ingresos Totales
                </strong>

                <span>

                    $

                    {{ number_format(
                        $ventas->sum('total_venta'),
                        0,
                        ',',
                        '.'
                    ) }}

                </span>

            </td>

        </tr>

    </table>


    {{-- TABLA --}}
    <table class="tabla">

        <thead>

            <tr>

                <th>#</th>

                <th>Animal</th>

                <th>Cliente</th>

                <th>Documento</th>

                <th>Teléfono</th>

                <th>Fecha Venta</th>

                <th>Peso Venta</th>

                <th>Precio/Kg</th>

                <th>Total Venta</th>

            </tr>

        </thead>


        <tbody>

        @forelse($ventas as $venta)

            <tr>

                <td class="center">
                    {{ $loop->iteration }}
                </td>


                <td class="center">

                    @if($venta->animal)

                        {{ $venta->animal->codigo }}

                    @else

                        Sin animal

                    @endif

                </td>


                <td>
                    {{ $venta->cliente }}
                </td>


                <td class="center">
                    {{ $venta->documento_cliente ?? 'N/A' }}
                </td>


                <td class="center">
                    {{ $venta->telefono_cliente ?? 'N/A' }}
                </td>


                <td class="center">

                    {{ \Carbon\Carbon::parse(
                        $venta->fecha_venta
                    )->format('d/m/Y') }}

                </td>


                <td class="center">

                    {{ number_format(
                        $venta->peso_venta,
                        2
                    ) }}

                    Kg

                </td>


                <td class="money">

                    $

                    {{ number_format(
                        $venta->precio_kilo,
                        0,
                        ',',
                        '.'
                    ) }}

                </td>


                <td class="money">

                    <strong>

                        $

                        {{ number_format(
                            $venta->total_venta,
                            0,
                            ',',
                            '.'
                        ) }}

                    </strong>

                </td>

            </tr>

        @empty

            <tr>

                <td colspan="9"
                    class="sin-registros">

                    No existen ventas registradas
                    con los filtros seleccionados.

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>


    {{-- PIE --}}
    <div class="footer">

        PorciTech - Sistema de Gestión Porcina

    </div>


</body>

</html>