<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Granja;
use App\Models\Racion;
use App\Models\Reproduccion;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AnimalController extends Controller
{
    /**
     * =========================================================
     * LISTADO DE ANIMALES
     * =========================================================
     */
    public function index()
    {
        $animales = Animal::with('granja')
            ->orderBy('codigo')
            ->get();

        return view('animales.index', compact('animales'));
    }


    /**
     * =========================================================
     * CREAR ANIMAL
     * =========================================================
     */
    public function create()
    {
        $granjas = Granja::all();

        $madres = Animal::where('sexo', 'Hembra')
            ->where('estado', 'Activo')
            ->where('etapa', 'Reproductor')
            ->orderBy('codigo')
            ->get();

        $padres = Animal::where('sexo', 'Macho')
            ->where('estado', 'Activo')
            ->where('etapa', 'Reproductor')
            ->orderBy('codigo')
            ->get();

        return view('animales.create', compact(
            'granjas',
            'madres',
            'padres'
        ));
    }


    /**
     * =========================================================
     * GUARDAR ANIMAL
     * =========================================================
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required',
            'raza' => 'required',
            'sexo' => 'required',
            'fecha_nacimiento' => 'required|date',
            'peso_actual' => 'required|numeric|min:0',
            'etapa' => 'required',
            'origen' => 'required',
            'estado' => 'required',
            'granja_id' => 'required|exists:granjas,id',
        ]);

        Animal::create($request->all());

        return redirect()
            ->route('animales.index')
            ->with('success', 'Animal registrado correctamente');
    }


    /**
     * =========================================================
     * HISTORIA CLÍNICA Y PRODUCTIVA
     * =========================================================
     */
    public function show(Animal $animale)
    {
        /*
        |--------------------------------------------------------------------------
        | CARGAR HISTORIA COMPLETA
        |--------------------------------------------------------------------------
        */

        $animale->load([
            'granja',

            'alimentaciones' => function ($query) {
                $query->orderBy('fecha', 'desc');
            },

            'producciones' => function ($query) {
                $query->orderBy('fecha_pesaje', 'desc');
            },

            'sanidades' => function ($query) {
                $query->orderBy('fecha', 'desc');
            },

            'ventas' => function ($query) {
                $query->orderBy('fecha_venta', 'desc');
            },

            'reproduccionesHembra' => function ($query) {
                $query->orderBy('fecha_celo', 'desc');
            },

            'reproduccionesMacho' => function ($query) {
                $query->orderBy('fecha_servicio', 'desc');
            },
        ]);


        /*
        |--------------------------------------------------------------------------
        | MADRE Y PADRE
        |--------------------------------------------------------------------------
        */

        $madre = null;
        $padre = null;

        if ($animale->madre_id) {
            $madre = Animal::find($animale->madre_id);
        }

        if ($animale->padre_id) {
            $padre = Animal::find($animale->padre_id);
        }


        /*
        |--------------------------------------------------------------------------
        | RACIONES
        |--------------------------------------------------------------------------
        */

        $raciones = Racion::orderBy('etapa')
            ->orderBy('sexo')
            ->orderBy('peso_min')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | REPRODUCCIONES
        |--------------------------------------------------------------------------
        */

        $reproducciones = Reproduccion::orderByDesc('fecha_servicio')
            ->get()
            ->groupBy('hembra_id')
            ->map(function ($registros) {
                return $registros->first();
            });


        /*
        |--------------------------------------------------------------------------
        | ALIMENTACIÓN AUTOMÁTICA
        |--------------------------------------------------------------------------
        */

        $racionAutomatica = null;
        $cantidadAutomatica = null;
        $condicionReproductiva = null;
        $diasGestacion = null;


        if ($animale->estado === 'Activo') {

            $condicionReproductiva = $this->obtenerCondicionReproductiva(
                $animale,
                $reproducciones
            );

            $diasGestacion = $this->obtenerDiasGestacion(
                $animale,
                $reproducciones
            );

            $racionAutomatica = $this->obtenerRacion(
                $animale,
                $raciones,
                $reproducciones
            );

            $cantidadAutomatica = $this->obtenerCantidad(
                $animale,
                $raciones,
                $reproducciones
            );
        }


        /*
        |--------------------------------------------------------------------------
        | CANTIDAD FINAL
        |--------------------------------------------------------------------------
        */

        $cantidadMostrar = $cantidadAutomatica;
        $alimentacionAjustada = false;


        if (
            $animale->cantidad_ajustada !== null &&
            $animale->cantidad_ajustada !== ''
        ) {

            $cantidadMostrar = $animale->cantidad_ajustada;
            $alimentacionAjustada = true;
        }


        /*
        |--------------------------------------------------------------------------
        | DEVOLVER VISTA
        |--------------------------------------------------------------------------
        */

        return view('animales.show', compact(
            'animale',
            'madre',
            'padre',
            'racionAutomatica',
            'cantidadAutomatica',
            'cantidadMostrar',
            'alimentacionAjustada',
            'condicionReproductiva',
            'diasGestacion'
        ));
    }


    /**
     * =========================================================
     * EDITAR ANIMAL
     * =========================================================
     */
    public function edit(Animal $animale)
    {
        $granjas = Granja::all();

        $madres = Animal::where('sexo', 'Hembra')
            ->where('estado', 'Activo')
            ->where('etapa', 'Reproductor')
            ->where('id', '!=', $animale->id)
            ->orderBy('codigo')
            ->get();

        $padres = Animal::where('sexo', 'Macho')
            ->where('estado', 'Activo')
            ->where('etapa', 'Reproductor')
            ->where('id', '!=', $animale->id)
            ->orderBy('codigo')
            ->get();

        return view('animales.edit', compact(
            'animale',
            'granjas',
            'madres',
            'padres'
        ));
    }


    /**
     * =========================================================
     * ACTUALIZAR ANIMAL
     * =========================================================
     */
    public function update(Request $request, Animal $animale)
    {
        $request->validate([
            'codigo' => 'required',
            'raza' => 'required',
            'sexo' => 'required',
            'fecha_nacimiento' => 'required|date',
            'peso_actual' => 'required|numeric|min:0',
            'etapa' => 'required',
            'origen' => 'required',
            'estado' => 'required',
            'granja_id' => 'required|exists:granjas,id',
        ]);

        $animale->update($request->all());

        return redirect()
            ->route('animales.index')
            ->with('success', 'Animal actualizado correctamente');
    }


    /**
     * =========================================================
     * ELIMINAR ANIMAL
     * =========================================================
     */
    public function destroy(Animal $animale)
    {
        $animale->delete();

        return redirect()
            ->route('animales.index')
            ->with('success', 'Animal eliminado correctamente');
    }


    /**
     * =========================================================
     * CONDICIÓN REPRODUCTIVA
     * =========================================================
     */
    private function obtenerCondicionReproductiva(
        $animal,
        $reproducciones
    ) {
        if (!$animal) {
            return null;
        }

        if (
            $animal->sexo === 'Macho' &&
            $animal->etapa === 'Reproductor'
        ) {
            return 'Reposo';
        }

        if (
            $animal->sexo !== 'Hembra' ||
            $animal->etapa !== 'Reproductor'
        ) {
            return null;
        }

        if (!$reproducciones->has($animal->id)) {
            return 'Mantenimiento';
        }

        $reproduccion = $reproducciones->get($animal->id);

        if (
            in_array(
                $reproduccion->estado,
                ['Gestante', 'Servida']
            )
        ) {
            return 'Gestante';
        }

        if (
            $reproduccion->estado === 'Parida' &&
            !empty($reproduccion->fecha_parto)
        ) {
            return 'Lactante';
        }

        if (
            in_array(
                $reproduccion->estado,
                ['En_Celo', 'Fallida']
            )
        ) {
            return 'Vacia';
        }

        return 'Mantenimiento';
    }


    /**
     * =========================================================
     * DÍAS DE GESTACIÓN
     * =========================================================
     */
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


    /**
     * =========================================================
     * BUSCAR RACIÓN AUTOMÁTICA
     * =========================================================
     */
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


    /**
     * =========================================================
     * CANTIDAD AUTOMÁTICA
     * =========================================================
     */
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

            $reproduccion = $reproducciones->get(
                $animal->id
            );

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