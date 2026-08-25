<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>
        Reporte de Reproducción
    </title>

    <style>

        @page {
            margin: 30px 25px;
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
            margin: 5px 0;
            font-size: 16px;
        }

        .fecha {
            font-size: 10px;
            color: #666;
        }

        .resumen {
            width: 100%;
            margin-bottom: 18px;
        }

        .resumen td {
            width: 25%;
            padding: 8px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .resumen strong {
            display: block;
            font-size: 10px;
            margin-bottom: 5px;
        }

        .resumen span {
            font-size: 17px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #198754;
            color: white;
            border: 1px solid #146c43;
            padding: 7px 5px;
            text-align: center;
            font-size: 9px;
        }

        td {
            border: 1px solid #ccc;
            padding: 6px 5px;
            text-align: center;
            vertical-align: middle;
            font-size: 9px;
        }

        tr:nth-child(even) {
            background-color: #f5f5f5;
        }

        .estado {
            font-weight: bold;
        }

        .filtros {
            margin-bottom: 15px;
            padding: 8px;
            border: 1px solid #ddd;
            background-color: #f8f9fa;
        }

        .filtros-title {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 8px;
            color: #777;
        }

    </style>

</head>


<body>

    {{-- ==========================================================
         ENCABEZADO
    =========================================================== --}}

    <div class="header">

        <h1>
            PorciTech
        </h1>

        <h2>
            Reporte de Reproducción
        </h2>

        <div class="fecha">

            Fecha de generación:
            {{ now()->format('d/m/Y H:i') }}

        </div>

    </div>


    {{-- ==========================================================
         FILTROS APLICADOS
    =========================================================== --}}

    @if(
        request()->filled('hembra_id') ||
        request()->filled('macho_id') ||
        request()->filled('tipo_monta') ||
        request()->filled('estado') ||
        request()->filled('fecha_desde') ||
        request()->filled('fecha_hasta')
    )

        <div class="filtros">

            <div class="filtros-title">
                Filtros aplicados:
            </div>

            @if(request()->filled('hembra_id'))

                Hembra ID:
                {{ request('hembra_id') }}

            @endif


            @if(request()->filled('macho_id'))

                &nbsp; | &nbsp;

                Macho ID:
                {{ request('macho_id') }}

            @endif


            @if(request()->filled('tipo_monta'))

                &nbsp; | &nbsp;

                Tipo:
                {{ request('tipo_monta') }}

            @endif


            @if(request()->filled('estado'))

                &nbsp; | &nbsp;

                Estado:
                {{ request('estado') }}

            @endif


            @if(request()->filled('fecha_desde'))

                &nbsp; | &nbsp;

                Desde:
                {{ \Carbon\Carbon::parse(request('fecha_desde'))->format('d/m/Y') }}

            @endif


            @if(request()->filled('fecha_hasta'))

                &nbsp; | &nbsp;

                Hasta:
                {{ \Carbon\Carbon::parse(request('fecha_hasta'))->format('d/m/Y') }}

            @endif

        </div>

    @endif


    {{-- ==========================================================
         RESUMEN
    =========================================================== --}}

    <table class="resumen">

        <tr>

            <td>

                <strong>
                    Servicios
                </strong>

                <span>
                    {{ $reproducciones->count() }}
                </span>

            </td>


            <td>

                <strong>
                    Partos
                </strong>

                <span>
                    {{ $reproducciones->whereNotNull('fecha_parto')->count() }}
                </span>

            </td>


            <td>

                <strong>
                    Crías Totales
                </strong>

                <span>
                    {{ $reproducciones->sum('crias_totales') }}
                </span>

            </td>


            <td>

                <strong>
                    Crías Vivas
                </strong>

                <span>
                    {{ $reproducciones->sum('crias_vivas') }}
                </span>

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
                    Hembra
                </th>

                <th>
                    Macho
                </th>

                <th>
                    Pajilla
                </th>

                <th>
                    Tipo Monta
                </th>

                <th>
                    Fecha Servicio
                </th>

                <th>
                    Parto
                </th>

                <th>
                    Crías
                </th>

                <th>
                    Estado
                </th>

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

                    {{ $reproduccion->tipo_monta ?? 'N/A' }}

                </td>


                <td>

                    @if($reproduccion->fecha_servicio)

                        {{ \Carbon\Carbon::parse($reproduccion->fecha_servicio)->format('d/m/Y') }}

                    @else

                        N/A

                    @endif

                </td>


                <td>

                    @if($reproduccion->fecha_parto)

                        {{ \Carbon\Carbon::parse($reproduccion->fecha_parto)->format('d/m/Y') }}

                    @else

                        Pendiente

                    @endif

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


                <td class="estado">

                    {{ $reproduccion->estado ?? 'N/A' }}

                </td>

            </tr>

        @empty

            <tr>

                <td colspan="9">

                    No existen registros de reproducción
                    con los filtros seleccionados.

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>


    {{-- ==========================================================
         PIE
    =========================================================== --}}

    <div class="footer">

        PorciTech -
        Reporte generado automáticamente

    </div>

</body>

</html>