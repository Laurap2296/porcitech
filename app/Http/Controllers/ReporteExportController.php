<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Granja;
use App\Models\Venta;
use App\Models\Reproduccion;
use App\Models\Produccion;
use App\Models\Sanidad;
use App\Models\Racion;

use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReporteExportController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | PDF - ANIMALES
    |--------------------------------------------------------------------------
    */

    public function animalesPDF()
    {
        $query = Animal::with('granja')
            ->orderBy('codigo');

        if (request()->filled('estado')) {
            $query->where('estado', request('estado'));
        }

        if (request()->filled('etapa')) {
            $query->where('etapa', request('etapa'));
        }

        if (request()->filled('sexo')) {
            $query->where('sexo', request('sexo'));
        }

        if (request()->filled('raza')) {
            $query->where('raza', request('raza'));
        }

        if (request()->filled('granja_id')) {
            $query->where('granja_id', request('granja_id'));
        }

        $animales = $query->get();

        $pdf = Pdf::loadView(
            'reportes.pdf.animales',
            compact('animales')
        );

        return $pdf->download('reporte_animales.pdf');
    }


    /*
    |--------------------------------------------------------------------------
    | PDF - GRANJAS
    |--------------------------------------------------------------------------
    */

    public function granjasPDF()
    {
        $estado = request('estado', 'todos');

        $query = Granja::query();

        if ($estado !== 'todos') {
            $query->where('estado', $estado);
        }

        $granjas = $query
            ->orderBy('nombre')
            ->get();

        $pdf = Pdf::loadView(
            'reportes.pdf.granjas',
            compact(
                'granjas',
                'estado'
            )
        );

        return $pdf->download('reporte_granjas.pdf');
    }


    /*
    |--------------------------------------------------------------------------
    | PDF - ALIMENTACIÓN
    |--------------------------------------------------------------------------
    */

    public function alimentacionPDF()
    {
        $raciones = Racion::orderBy('etapa')
            ->orderBy('sexo')
            ->orderBy('peso_min')
            ->get();

        $reproducciones = Reproduccion::orderByDesc('fecha_servicio')
            ->get()
            ->groupBy('hembra_id')
            ->map(function ($registros) {
                return $registros->first();
            });

        $animales = Animal::where(
            'estado',
            'Activo'
        )
            ->orderBy('codigo')
            ->get();

        $animales->each(function ($animal) use (
            $raciones,
            $reproducciones
        ) {
            $animal->condicion_reproductiva =
                $this->obtenerCondicionReproductiva(
                    $animal,
                    $reproducciones
                );

            $animal->dias_gestacion =
                $this->obtenerDiasGestacion(
                    $animal,
                    $reproducciones
                );

            $animal->racion_recomendada =
                $this->obtenerRacion(
                    $animal,
                    $raciones,
                    $reproducciones
                );

            $animal->cantidad_recomendada =
                $this->obtenerCantidad(
                    $animal,
                    $raciones,
                    $reproducciones
                );

            if ($animal->cantidad_ajustada !== null) {
                $animal->cantidad_mostrar =
                    $animal->cantidad_ajustada;

                $animal->tipo_cantidad =
                    'Ajustada';
            } else {
                $animal->cantidad_mostrar =
                    $animal->cantidad_recomendada;

                $animal->tipo_cantidad =
                    'Automática';
            }

            $animal->observacion_reporte =
                $animal->observacion_alimentacion;
        });

        if (request()->filled('animal_id')) {
            $animales = $animales->filter(
                function ($animal) {
                    return $animal->id == request('animal_id');
                }
            )->values();
        }

        if (request()->filled('sexo')) {
            $animales = $animales->filter(
                function ($animal) {
                    return $animal->sexo === request('sexo');
                }
            )->values();
        }

        if (request()->filled('etapa')) {
            $animales = $animales->filter(
                function ($animal) {
                    return $animal->etapa === request('etapa');
                }
            )->values();
        }

        if (request()->filled('condicion')) {
            $animales = $animales->filter(
                function ($animal) {
                    return $animal->condicion_reproductiva ===
                        request('condicion');
                }
            )->values();
        }

        $totalAnimales = $animales->count();

        $totalAjustadas = $animales
            ->where('tipo_cantidad', 'Ajustada')
            ->count();

        $totalAutomaticas = $animales
            ->where('tipo_cantidad', 'Automática')
            ->count();

        $pdf = Pdf::loadView(
            'reportes.pdf.alimentacion',
            compact(
                'animales',
                'totalAnimales',
                'totalAjustadas',
                'totalAutomaticas'
            )
        );

        $pdf->setPaper(
            'a4',
            'landscape'
        );

        return $pdf->download(
            'reporte_alimentacion.pdf'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PDF - SANIDAD
    |--------------------------------------------------------------------------
    */

    public function sanidadPDF()
    {
        $query = Sanidad::with('animal');

        if (request()->filled('animal_id')) {
            $query->where(
                'animal_id',
                request('animal_id')
            );
        }

        if (request()->filled('tipo_registro')) {
            $query->where(
                'tipo_registro',
                request('tipo_registro')
            );
        }

        if (request()->filled('fecha_desde')) {
            $query->whereDate(
                'fecha',
                '>=',
                request('fecha_desde')
            );
        }

        if (request()->filled('fecha_hasta')) {
            $query->whereDate(
                'fecha',
                '<=',
                request('fecha_hasta')
            );
        }

        $sanidades = $query
            ->orderByDesc('fecha')
            ->orderByDesc('id')
            ->get();

        $sanidadesAgrupadas = $sanidades
            ->groupBy('animal_id');

        $totalRegistros = $sanidades->count();

        $totalAnimales = $sanidades
            ->pluck('animal_id')
            ->filter()
            ->unique()
            ->count();

        $proximosControles = $sanidades
            ->filter(function ($sanidad) {

                if (empty($sanidad->proximo_control)) {
                    return false;
                }

                try {
                    return Carbon::parse(
                        $sanidad->proximo_control
                    )->greaterThanOrEqualTo(
                        Carbon::today()
                    );
                } catch (\Exception $e) {
                    return false;
                }
            })
            ->count();

        $pdf = Pdf::loadView(
            'reportes.pdf.sanidad',
            compact(
                'sanidades',
                'sanidadesAgrupadas',
                'totalRegistros',
                'totalAnimales',
                'proximosControles'
            )
        );

        $pdf->setPaper(
            'a4',
            'landscape'
        );

        return $pdf->download(
            'reporte_sanidad.pdf'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PDF - PRODUCCIÓN
    |--------------------------------------------------------------------------
    */

    public function produccionPDF()
    {
        $query = Produccion::with('animal');

        if (request()->filled('animal_id')) {
            $query->where(
                'animal_id',
                request('animal_id')
            );
        }

        if (request()->filled('tipo_registro')) {
            $query->where(
                'tipo_registro',
                request('tipo_registro')
            );
        }

        if (request()->filled('fecha_desde')) {
            $query->whereDate(
                'fecha_pesaje',
                '>=',
                request('fecha_desde')
            );
        }

        if (request()->filled('fecha_hasta')) {
            $query->whereDate(
                'fecha_pesaje',
                '<=',
                request('fecha_hasta')
            );
        }

        $producciones = $query
            ->orderByDesc('fecha_pesaje')
            ->orderByDesc('id')
            ->get();

        $producciones->each(function ($produccion) {

            if (
                $produccion->tipo_registro === 'sacrificio' &&
                $produccion->rendimiento === null &&
                $produccion->peso_vivo !== null &&
                $produccion->peso_canal !== null &&
                $produccion->peso_vivo > 0
            ) {
                $produccion->rendimiento =
                    (
                        $produccion->peso_canal /
                        $produccion->peso_vivo
                    ) * 100;
            }
        });

        $pdf = Pdf::loadView(
            'reportes.pdf.produccion',
            compact('producciones')
        );

        $pdf->setPaper(
            'a4',
            'landscape'
        );

        return $pdf->download(
            'reporte_produccion.pdf'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PDF - VENTAS
    |--------------------------------------------------------------------------
    |
    | Se modificó únicamente esta sección.
    |
    | Incluye:
    | - Filtro por animal
    | - Filtro por fecha desde
    | - Filtro por fecha hasta
    | - Total de ventas
    | - Animales vendidos
    | - Ingresos totales
    | - Fecha de generación
    |
    |--------------------------------------------------------------------------
    */

    public function ventasPDF()
    {
        /*
        |--------------------------------------------------------------------------
        | CONSULTA PRINCIPAL
        |--------------------------------------------------------------------------
        */

        $query = Venta::with('animal');


        /*
        |--------------------------------------------------------------------------
        | FILTRO POR ANIMAL
        |--------------------------------------------------------------------------
        */

        if (request()->filled('animal_id')) {
            $query->where(
                'animal_id',
                request('animal_id')
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FILTRO FECHA DESDE
        |--------------------------------------------------------------------------
        */

        if (request()->filled('fecha_desde')) {
            $query->whereDate(
                'fecha_venta',
                '>=',
                request('fecha_desde')
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FILTRO FECHA HASTA
        |--------------------------------------------------------------------------
        */

        if (request()->filled('fecha_hasta')) {
            $query->whereDate(
                'fecha_venta',
                '<=',
                request('fecha_hasta')
            );
        }


        /*
        |--------------------------------------------------------------------------
        | OBTENER VENTAS
        |--------------------------------------------------------------------------
        |
        | Se ordenan por fecha de venta y luego por ID.
        |
        */

        $ventas = $query
            ->orderByDesc('fecha_venta')
            ->orderByDesc('id')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | RESUMEN DEL REPORTE
        |--------------------------------------------------------------------------
        */

        $totalVentas = $ventas->count();

        $animalesVendidos = $ventas
            ->pluck('animal_id')
            ->filter()
            ->unique()
            ->count();

        $ingresosTotales = $ventas->sum(function ($venta) {
            return (float) ($venta->total_venta ?? 0);
        });


        /*
        |--------------------------------------------------------------------------
        | FECHA DE GENERACIÓN
        |--------------------------------------------------------------------------
        */

        $fechaGeneracion = Carbon::now()
            ->format('d/m/Y H:i');


        /*
        |--------------------------------------------------------------------------
        | GENERAR PDF
        |--------------------------------------------------------------------------
        |
        | Se envían TODAS las variables necesarias para que la vista
        | pueda mostrar tanto el resumen como la tabla.
        |
        */

        $pdf = Pdf::loadView(
            'reportes.pdf.ventas',
            compact(
                'ventas',
                'totalVentas',
                'animalesVendidos',
                'ingresosTotales',
                'fechaGeneracion'
            )
        );


        /*
        |--------------------------------------------------------------------------
        | FORMATO
        |--------------------------------------------------------------------------
        */

        $pdf->setPaper(
            'a4',
            'landscape'
        );


        /*
        |--------------------------------------------------------------------------
        | DESCARGAR
        |--------------------------------------------------------------------------
        */

        return $pdf->download(
            'reporte_ventas.pdf'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PDF - REPRODUCCIÓN
    |--------------------------------------------------------------------------
    */

    public function reproduccionPDF()
    {
        $query = Reproduccion::with([
            'hembra',
            'macho',
            'pajilla'
        ]);

        if (request()->filled('hembra_id')) {
            $query->where(
                'hembra_id',
                request('hembra_id')
            );
        }

        if (request()->filled('macho_id')) {
            $query->where(
                'macho_id',
                request('macho_id')
            );
        }

        if (request()->filled('tipo_monta')) {
            $query->where(
                'tipo_monta',
                request('tipo_monta')
            );
        }

        if (request()->filled('estado')) {
            $query->where(
                'estado',
                request('estado')
            );
        }

        if (request()->filled('fecha_desde')) {
            $query->whereDate(
                'fecha_servicio',
                '>=',
                request('fecha_desde')
            );
        }

        if (request()->filled('fecha_hasta')) {
            $query->whereDate(
                'fecha_servicio',
                '<=',
                request('fecha_hasta')
            );
        }

        $reproducciones = $query
            ->latest()
            ->get();

        $pdf = Pdf::loadView(
            'reportes.pdf.reproduccion',
            compact('reproducciones')
        );

        return $pdf->download(
            'reporte_reproduccion.pdf'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PDF - ANÁLISIS DE CERDAS
    |--------------------------------------------------------------------------
    */
/*
|--------------------------------------------------------------------------
| PDF - ANÁLISIS DE CERDAS
|--------------------------------------------------------------------------
*/

public function analisisCerdasPDF()
{
    /*
    |--------------------------------------------------------------------------
    | CONSULTA PRINCIPAL
    |--------------------------------------------------------------------------
    */

    $query = DB::table('reproduccion')
        ->join(
            'animales',
            'reproduccion.hembra_id',
            '=',
            'animales.id'
        )
        ->where(
            'animales.sexo',
            'Hembra'
        )
        ->where(
            'animales.etapa',
            'Reproductor'
        );


    /*
    |--------------------------------------------------------------------------
    | FILTRO POR CERDA
    |--------------------------------------------------------------------------
    */

    if (request()->filled('hembra_id')) {

        $query->where(
            'reproduccion.hembra_id',
            request('hembra_id')
        );

    }


    /*
    |--------------------------------------------------------------------------
    | FILTRO FECHA DESDE
    |--------------------------------------------------------------------------
    */

    if (request()->filled('fecha_desde')) {

        $query->whereDate(
            'reproduccion.fecha_servicio',
            '>=',
            request('fecha_desde')
        );

    }


    /*
    |--------------------------------------------------------------------------
    | FILTRO FECHA HASTA
    |--------------------------------------------------------------------------
    */

    if (request()->filled('fecha_hasta')) {

        $query->whereDate(
            'reproduccion.fecha_servicio',
            '<=',
            request('fecha_hasta')
        );

    }


    /*
    |--------------------------------------------------------------------------
    | GENERAR ANÁLISIS
    |--------------------------------------------------------------------------
    */

    $cerdas = $query
        ->select(

            'animales.id',

            'animales.codigo',

            'animales.raza',

            DB::raw(
                'COUNT(reproduccion.id) as servicios'
            ),

            DB::raw(
                'COUNT(reproduccion.fecha_parto) as partos'
            ),

            DB::raw(
                'COALESCE(
                    SUM(reproduccion.crias_totales),
                    0
                ) as total_crias'
            ),

            DB::raw(
                'COALESCE(
                    SUM(reproduccion.crias_vivas),
                    0
                ) as vivas'
            ),

            DB::raw(
                'COALESCE(
                    SUM(reproduccion.crias_muertas),
                    0
                ) as muertas'
            ),

            DB::raw(
                'ROUND(
                    COALESCE(
                        AVG(reproduccion.crias_vivas),
                        0
                    ),
                    2
                ) as promedio'
            )

        )
        ->groupBy(

            'animales.id',

            'animales.codigo',

            'animales.raza'

        )
        ->orderByDesc('vivas')
        ->get();


    /*
    |--------------------------------------------------------------------------
    | RESUMEN
    |--------------------------------------------------------------------------
    */

    $totalCerdas = $cerdas->count();

    $totalServicios = $cerdas->sum(
        'servicios'
    );

    $totalPartos = $cerdas->sum(
        'partos'
    );

    $totalVivas = $cerdas->sum(
        'vivas'
    );


    /*
    |--------------------------------------------------------------------------
    | FECHA DE GENERACIÓN
    |--------------------------------------------------------------------------
    */

    $fechaGeneracion = Carbon::now()
        ->format('d/m/Y H:i');


    /*
    |--------------------------------------------------------------------------
    | GENERAR PDF
    |--------------------------------------------------------------------------
    */

    $pdf = Pdf::loadView(
        'reportes.pdf.analisis_cerdas',
        compact(
            'cerdas',
            'totalCerdas',
            'totalServicios',
            'totalPartos',
            'totalVivas',
            'fechaGeneracion'
        )
    );


    /*
    |--------------------------------------------------------------------------
    | FORMATO HORIZONTAL
    |--------------------------------------------------------------------------
    */

    $pdf->setPaper(
        'a4',
        'landscape'
    );


    /*
    |--------------------------------------------------------------------------
    | DESCARGAR
    |--------------------------------------------------------------------------
    */

    return $pdf->download(
        'analisis_cerdas.pdf'
    );
}
/*
    |--------------------------------------------------------------------------
    | FUNCIONES AUXILIARES DE ALIMENTACIÓN
    |--------------------------------------------------------------------------
    */

    private function obtenerCondicionReproductiva(
        $animal,
        $reproducciones
    ) {
        if (
            !$animal ||
            $animal->sexo !== 'Hembra' ||
            $animal->etapa !== 'Reproductor'
        ) {
            if (
                $animal &&
                $animal->sexo === 'Macho' &&
                $animal->etapa === 'Reproductor'
            ) {
                return 'Reposo';
            }

            return null;
        }

        if (!$reproducciones->has($animal->id)) {
            return 'Mantenimiento';
        }

        $reproduccion =
            $reproducciones->get($animal->id);

        if ($reproduccion->estado === 'Gestante') {
            return 'Gestante';
        }

        if ($reproduccion->estado === 'Servida') {
            return 'Gestante';
        }

        if (
            $reproduccion->estado === 'Parida' &&
            !empty($reproduccion->fecha_parto)
        ) {
            return 'Lactante';
        }

        if ($reproduccion->estado === 'En_Celo') {
            return 'Vacia';
        }

        if ($reproduccion->estado === 'Fallida') {
            return 'Vacia';
        }

        return 'Mantenimiento';
    }


    private function obtenerDiasGestacion(
        $animal,
        $reproducciones
    ) {
        if (
            !$animal ||
            $animal->sexo !== 'Hembra' ||
            $animal->etapa !== 'Reproductor'
        ) {
            return null;
        }

        if (!$reproducciones->has($animal->id)) {
            return null;
        }

        $reproduccion =
            $reproducciones->get($animal->id);

        if (
            !in_array(
                $reproduccion->estado,
                ['Gestante', 'Servida']
            )
        ) {
            return null;
        }

        if (!$reproduccion->fecha_servicio) {
            return null;
        }

        return Carbon::parse(
            $reproduccion->fecha_servicio
        )->diffInDays(
            Carbon::today()
        ) + 1;
    }


    private function obtenerRacion(
        $animal,
        $raciones,
        $reproducciones
    ) {
        if (!$animal) {
            return null;
        }

        if (
            in_array(
                $animal->estado,
                ['Vendido', 'Muerto']
            )
        ) {
            return null;
        }

        $condicion =
            $this->obtenerCondicionReproductiva(
                $animal,
                $reproducciones
            );

        $diasGestacion =
            $this->obtenerDiasGestacion(
                $animal,
                $reproducciones
            );

        return $raciones->first(
            function ($racion) use (
                $animal,
                $condicion,
                $diasGestacion
            ) {
                if ($racion->etapa !== $animal->etapa) {
                    return false;
                }

                if (
                    $racion->sexo !== 'Ambos' &&
                    $racion->sexo !== $animal->sexo
                ) {
                    return false;
                }

                if ($racion->condicion) {
                    if ($condicion !== null) {
                        if (
                            $racion->condicion !== $condicion
                        ) {
                            return false;
                        }
                    } else {
                        if (
                            $racion->condicion !== 'Normal'
                        ) {
                            return false;
                        }
                    }
                }

                if (
                    $racion->peso_min !== null &&
                    $animal->peso_actual < $racion->peso_min
                ) {
                    return false;
                }

                if (
                    $racion->peso_max !== null &&
                    $animal->peso_actual > $racion->peso_max
                ) {
                    return false;
                }

                if (
                    $racion->dias_gestacion_min !== null ||
                    $racion->dias_gestacion_max !== null
                ) {
                    if ($diasGestacion === null) {
                        return false;
                    }

                    if (
                        $racion->dias_gestacion_min !== null &&
                        $diasGestacion < $racion->dias_gestacion_min
                    ) {
                        return false;
                    }

                    if (
                        $racion->dias_gestacion_max !== null &&
                        $diasGestacion > $racion->dias_gestacion_max
                    ) {
                        return false;
                    }
                }

                return true;
            }
        );
    }


    private function obtenerCantidad(
        $animal,
        $raciones,
        $reproducciones
    ) {
        $racion = $this->obtenerRacion(
            $animal,
            $raciones,
            $reproducciones
        );

        if (!$racion) {
            return null;
        }

        $condicion =
            $this->obtenerCondicionReproductiva(
                $animal,
                $reproducciones
            );

        if (
            $condicion === 'Lactante' &&
            $reproducciones->has($animal->id)
        ) {
            $reproduccion =
                $reproducciones->get($animal->id);

            $criasVivas = (int) (
                $reproduccion->crias_vivas ?? 0
            );

            return 2.50 + ($criasVivas * 0.50);
        }

        if (
            $racion->cantidad_min !== null &&
            $racion->cantidad_max !== null
        ) {
            return (
                $racion->cantidad_min +
                $racion->cantidad_max
            ) / 2;
        }

        return $racion->cantidad_min;
    }
}