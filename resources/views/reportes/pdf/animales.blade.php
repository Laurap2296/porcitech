<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Reporte de Animales - PorciTech</title>

    <style>

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #333;
        }

        .encabezado {
            text-align: center;
            margin-bottom: 15px;
        }

        .encabezado h1 {
            color: #198754;
            margin-bottom: 5px;
            font-size: 22px;
        }

        .encabezado p {
            margin: 3px;
        }

        .filtros {
            margin-top: 10px;
            margin-bottom: 15px;
            padding: 8px;
            border: 1px solid #198754;
            background-color: #f2f2f2;
            text-align: center;
        }

        .filtros strong {
            color: #198754;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
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

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .total {
            margin-top: 12px;
            text-align: right;
            font-weight: bold;
        }

        .pie {
            margin-top: 20px;
            text-align: center;
            font-size: 9px;
            color: #777;
        }

    </style>

</head>


<body>


    {{-- ENCABEZADO --}}

    <div class="encabezado">

        <h1>PorciTech</h1>

        <p>
            <strong>Reporte de Animales</strong>
        </p>

        <p>
            Fecha de generación:
            {{ date('d/m/Y H:i') }}
        </p>

    </div>


    {{-- FILTROS APLICADOS --}}

    <div class="filtros">

        <strong>Filtros aplicados:</strong>

        @if(request('estado'))

            Estado:
            {{ request('estado') }}

        @endif


        @if(request('etapa'))

            @if(request('estado'))
                |
            @endif

            Etapa:
            {{ request('etapa') }}

        @endif


        @if(request('sexo'))

            @if(request('estado') || request('etapa'))
                |
            @endif

            Sexo:
            {{ request('sexo') }}

        @endif


        @if(
            !request('estado') &&
            !request('etapa') &&
            !request('sexo')
        )

            Todos los animales

        @endif

    </div>


    {{-- TABLA --}}

    <table>

        <thead>

            <tr>

                <th>Código</th>

                <th>Raza</th>

                <th>Sexo</th>

                <th>Etapa</th>

                <th>Peso actual</th>

                <th>Origen</th>

                <th>Estado</th>

                <th>Granja</th>

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
                        {{ number_format($animal->peso_actual, 2) }} kg
                    </td>

                    <td>
                        {{ $animal->origen }}
                    </td>

                    <td>
                        {{ $animal->estado }}
                    </td>

                    <td>
                        {{ $animal->granja->nombre ?? 'Sin granja' }}
                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="8">

                        No hay animales registrados
                        con los filtros seleccionados.

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>


    {{-- TOTAL --}}

    <div class="total">

        Total de registros:
        {{ $animales->count() }}

    </div>


    {{-- PIE --}}

    <div class="pie">

        Sistema de gestión porcina PorciTech

    </div>


</body>

</html>