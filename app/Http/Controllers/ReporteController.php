<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Granja;
use App\Models\Venta;
use App\Models\Reproduccion;
use App\Models\Produccion;
use App\Models\Sanidad;
use App\Models\Racion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReporteController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | MENÚ PRINCIPAL DE REPORTES
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        return view('reportes.index');
    }


    /*
    |--------------------------------------------------------------------------
    | REPORTE DE ANIMALES
    |--------------------------------------------------------------------------
    */

    public function animales(Request $request)
    {
        $query = Animal::with('granja');

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('raza')) {
            $query->where('raza', $request->raza);
        }

        if ($request->filled('etapa')) {
            $query->where('etapa', $request->etapa);
        }

        if ($request->filled('sexo')) {
            $query->where('sexo', $request->sexo);
        }

        if ($request->filled('granja_id')) {
            $query->where('granja_id', $request->granja_id);
        }

        $animales = $query
            ->orderBy('codigo')
            ->get();

        $razas = Animal::whereNotNull('raza')
            ->where('raza', '!=', '')
            ->select('raza')
            ->distinct()
            ->orderBy('raza')
            ->pluck('raza');

        $etapas = Animal::whereNotNull('etapa')
            ->where('etapa', '!=', '')
            ->select('etapa')
            ->distinct()
            ->orderBy('etapa')
            ->pluck('etapa');

        $estados = Animal::whereNotNull('estado')
            ->where('estado', '!=', '')
            ->select('estado')
            ->distinct()
            ->orderBy('estado')
            ->pluck('estado');

        $granjas = Granja::orderBy('nombre')->get();

        return view(
            'reportes.animales',
            compact(
                'animales',
                'razas',
                'etapas',
                'estados',
                'granjas'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | REPORTE DE GRANJAS
    |--------------------------------------------------------------------------
    */

    public function granjas(Request $request)
    {
        $query = Granja::query();

        if (
            $request->filled('estado') &&
            $request->estado !== 'todos'
        ) {
            $query->where('estado', $request->estado);
        }

        $granjas = $query
            ->orderBy('nombre')
            ->get();

        $estado = $request->get('estado', 'todos');

        return view(
            'reportes.granjas',
            compact(
                'granjas',
                'estado'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | REPORTE DE ALIMENTACIÓN
    |--------------------------------------------------------------------------
    */

    public function alimentacion(Request $request)
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

        $animales = Animal::where('estado', 'Activo')
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

        if ($request->filled('animal_id')) {
            $animales = $animales->filter(function ($animal) use ($request) {
                return $animal->id == $request->animal_id;
            })->values();
        }

        if ($request->filled('sexo')) {
            $animales = $animales->filter(function ($animal) use ($request) {
                return $animal->sexo === $request->sexo;
            })->values();
        }

        if ($request->filled('etapa')) {
            $animales = $animales->filter(function ($animal) use ($request) {
                return $animal->etapa === $request->etapa;
            })->values();
        }

        if ($request->filled('condicion')) {
            $animales = $animales->filter(function ($animal) use ($request) {
                return $animal->condicion_reproductiva ===
                    $request->condicion;
            })->values();
        }

        $animalesFiltro = Animal::where('estado', 'Activo')
            ->orderBy('codigo')
            ->get();

        $sexos = Animal::where('estado', 'Activo')
            ->whereNotNull('sexo')
            ->where('sexo', '!=', '')
            ->select('sexo')
            ->distinct()
            ->orderBy('sexo')
            ->pluck('sexo');

        $etapas = Animal::where('estado', 'Activo')
            ->whereNotNull('etapa')
            ->where('etapa', '!=', '')
            ->select('etapa')
            ->distinct()
            ->orderBy('etapa')
            ->pluck('etapa');

        $condiciones = collect([
            'Reposo',
            'Mantenimiento',
            'Vacia',
            'Gestante',
            'Lactante'
        ]);

        $totalAnimales = $animales->count();

        $totalAjustadas = $animales
            ->where('tipo_cantidad', 'Ajustada')
            ->count();

        $totalAutomaticas = $animales
            ->where('tipo_cantidad', 'Automática')
            ->count();

        return view(
            'reportes.alimentacion',
            compact(
                'animales',
                'animalesFiltro',
                'sexos',
                'etapas',
                'condiciones',
                'totalAnimales',
                'totalAjustadas',
                'totalAutomaticas'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | REPORTE DE SANIDAD
    |--------------------------------------------------------------------------
    */

    public function sanidad(Request $request)
    {
        $query = Sanidad::with('animal');

        if ($request->filled('animal_id')) {
            $query->where(
                'animal_id',
                $request->animal_id
            );
        }

        if ($request->filled('tipo_registro')) {
            $query->where(
                'tipo_registro',
                $request->tipo_registro
            );
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate(
                'fecha',
                '>=',
                $request->fecha_desde
            );
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate(
                'fecha',
                '<=',
                $request->fecha_hasta
            );
        }

        $sanidades = $query
            ->orderBy('animal_id')
            ->orderByDesc('fecha')
            ->get();

        $sanidadesAgrupadas = $sanidades
            ->groupBy('animal_id');

        $animales = Animal::orderBy('codigo')->get();

        $tiposRegistro = Sanidad::whereNotNull('tipo_registro')
            ->where('tipo_registro', '!=', '')
            ->select('tipo_registro')
            ->distinct()
            ->orderBy('tipo_registro')
            ->pluck('tipo_registro');

        $totalRegistros = $sanidades->count();

        $totalAnimales = $sanidades
            ->pluck('animal_id')
            ->unique()
            ->count();

        $proximosControles = $sanidades
            ->filter(function ($sanidad) {
                return !empty($sanidad->proxima_fecha)
                    && Carbon::parse($sanidad->proxima_fecha)
                        ->greaterThanOrEqualTo(Carbon::today());
            })
            ->count();

        return view(
            'reportes.sanidad',
            compact(
                'sanidades',
                'sanidadesAgrupadas',
                'animales',
                'tiposRegistro',
                'totalRegistros',
                'totalAnimales',
                'proximosControles'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | REPORTE DE PRODUCCIÓN
    |--------------------------------------------------------------------------
    */

    public function produccion(Request $request)
    {
        $query = Produccion::with('animal');

        if ($request->filled('animal_id')) {
            $query->where(
                'animal_id',
                $request->animal_id
            );
        }

        if ($request->filled('tipo_registro')) {
            $query->where(
                'tipo_registro',
                $request->tipo_registro
            );
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate(
                'created_at',
                '>=',
                $request->fecha_desde
            );
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate(
                'created_at',
                '<=',
                $request->fecha_hasta
            );
        }

        $producciones = $query
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->get();

        $animales = Animal::orderBy('codigo')
            ->get();

        return view(
            'reportes.produccion',
            compact(
                'producciones',
                'animales'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | REPORTE DE VENTAS
    |--------------------------------------------------------------------------
    */

    public function ventas(Request $request)
    {
        $query = Venta::with('animal');

        if ($request->filled('animal_id')) {
            $query->where(
                'animal_id',
                $request->animal_id
            );
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate(
                'fecha_venta',
                '>=',
                $request->fecha_desde
            );
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate(
                'fecha_venta',
                '<=',
                $request->fecha_hasta
            );
        }

        $ventas = $query
            ->latest()
            ->get();

        $animales = Animal::orderBy('codigo')->get();

        return view(
            'reportes.ventas',
            compact(
                'ventas',
                'animales'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | REPORTE COMPLETO DE REPRODUCCIÓN
    |--------------------------------------------------------------------------
    */

    public function reproduccion(Request $request)
    {
        $query = Reproduccion::with([
            'hembra',
            'macho',
            'pajilla'
        ]);

        if ($request->filled('hembra_id')) {
            $query->where(
                'hembra_id',
                $request->hembra_id
            );
        }

        if ($request->filled('macho_id')) {
            $query->where(
                'macho_id',
                $request->macho_id
            );
        }

        if ($request->filled('tipo_monta')) {
            $query->where(
                'tipo_monta',
                $request->tipo_monta
            );
        }

        if ($request->filled('estado')) {
            $query->where(
                'estado',
                $request->estado
            );
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate(
                'fecha_servicio',
                '>=',
                $request->fecha_desde
            );
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate(
                'fecha_servicio',
                '<=',
                $request->fecha_hasta
            );
        }

        $reproducciones = $query
            ->latest()
            ->get();

        $hembras = Animal::where('sexo', 'Hembra')
            ->where('etapa', 'Reproductor')
            ->where('estado', 'Activo')
            ->orderBy('codigo')
            ->get();

        $machos = Animal::where('sexo', 'Macho')
            ->where('etapa', 'Reproductor')
            ->where('estado', 'Activo')
            ->orderBy('codigo')
            ->get();

        return view(
            'reportes.reproduccion',
            compact(
                'reproducciones',
                'hembras',
                'machos'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ANÁLISIS DE CERDAS REPRODUCTORAS
    |--------------------------------------------------------------------------
    */

    public function analisisCerdas(Request $request)
    {
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

        if ($request->filled('hembra_id')) {
            $query->where(
                'reproduccion.hembra_id',
                $request->hembra_id
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTRO FECHA DESDE
        |--------------------------------------------------------------------------
        */

        if ($request->filled('fecha_desde')) {
            $query->whereDate(
                'reproduccion.fecha_servicio',
                '>=',
                $request->fecha_desde
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTRO FECHA HASTA
        |--------------------------------------------------------------------------
        */

        if ($request->filled('fecha_hasta')) {
            $query->whereDate(
                'reproduccion.fecha_servicio',
                '<=',
                $request->fecha_hasta
            );
        }

        /*
        |--------------------------------------------------------------------------
        | CONSULTA DEL ANÁLISIS
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
                    'COALESCE(SUM(reproduccion.crias_totales), 0) as total_crias'
                ),

                DB::raw(
                    'COALESCE(SUM(reproduccion.crias_vivas), 0) as vivas'
                ),

                DB::raw(
                    'COALESCE(SUM(reproduccion.crias_muertas), 0) as muertas'
                ),

                DB::raw(
                    'ROUND(COALESCE(AVG(reproduccion.crias_vivas), 0), 2) as promedio'
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
        | CERDAS PARA EL FILTRO
        |--------------------------------------------------------------------------
        */

        $hembras = Animal::where('sexo', 'Hembra')
            ->where('etapa', 'Reproductor')
            ->orderBy('codigo')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | INDICADORES
        |--------------------------------------------------------------------------
        */

        $totalCerdas = $cerdas->count();

        $totalServicios = $cerdas->sum('servicios');

        $totalPartos = $cerdas->sum('partos');

        $totalVivas = $cerdas->sum('vivas');

        return view(
            'reportes.analisis_cerdas',
            compact(
                'cerdas',
                'hembras',
                'totalCerdas',
                'totalServicios',
                'totalPartos',
                'totalVivas'
            )
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

        $reproduccion = $reproducciones->get($animal->id);

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

        $reproduccion = $reproducciones->get($animal->id);

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

        $condicion = $this->obtenerCondicionReproductiva(
            $animal,
            $reproducciones
        );

        $diasGestacion = $this->obtenerDiasGestacion(
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

        $condicion = $this->obtenerCondicionReproductiva(
            $animal,
            $reproducciones
        );

        if (
            $condicion === 'Lactante' &&
            $reproducciones->has($animal->id)
        ) {
            $reproduccion = $reproducciones->get($animal->id);

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