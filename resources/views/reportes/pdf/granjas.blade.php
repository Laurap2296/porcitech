<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Reporte de Granjas - PorciTech</title>

    <style>

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #333;
        }

        .encabezado {
            text-align: center;
            margin-bottom: 20px;
        }

        .encabezado h1 {
            color: #198754;
            margin-bottom: 5px;
        }

        .encabezado p {
            margin: 3px;
        }

        .filtro {
            text-align: center;
            margin-bottom: 15px;
            font-size: 11px;
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

        <h1>
            PorciTech
        </h1>

        <p>
            <strong>
                Reporte de Granjas
            </strong>
        </p>

        <p>

            Fecha de generación:

            {{ date('d/m/Y H:i') }}

        </p>

    </div>



    {{-- FILTRO APLICADO --}}
    <div class="filtro">

        <strong>
            Filtro:
        </strong>


        @if(!$estado || $estado == 'todos')

            Todas las granjas

        @elseif($estado == 'activa')

            Granjas activas

        @elseif($estado == 'inactiva')

            Granjas inactivas

        @else

            Todas las granjas

        @endif

    </div>



    {{-- TABLA --}}
    <table>

        <thead>

            <tr>

                <th>
                    ID
                </th>

                <th>
                    Nombre
                </th>

                <th>
                    Ubicación
                </th>

                <th>
                    Propietario
                </th>

                <th>
                    Teléfono
                </th>

                <th>
                    Estado
                </th>

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
                        {{ ucfirst($granja->estado) }}
                    </td>

                </tr>


            @empty

                <tr>

                    <td colspan="6">

                        No hay granjas registradas
                        para el filtro seleccionado.

                    </td>

                </tr>

            @endforelse


        </tbody>

    </table>



    {{-- PIE --}}
    <div class="pie">

        Sistema de gestión porcina PorciTech

    </div>


</body>

</html>