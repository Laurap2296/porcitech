<?php

namespace App\Http\Controllers;

use App\Models\Alimentacion;
use App\Models\Animal;
use App\Models\Racion;
use App\Models\Reproduccion;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AlimentacionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LISTADO
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $animales = Animal::orderByRaw("
                CASE
                    WHEN estado = 'Activo' THEN 1
                    WHEN estado = 'Vendido' THEN 2
                    WHEN estado = 'Muerto' THEN 3
                    ELSE 4
                END
            ")
            ->orderBy('codigo')
            ->paginate(5);

        $raciones = Racion::orderBy('etapa')
            ->orderBy('sexo')
            ->orderBy('peso_min')
            ->get();

        $reproducciones = Reproduccion::orderByDesc('fecha_servicio')
            ->get()
            ->groupBy('hembra_id')
            ->map(function ($reproducciones) {
                return $reproducciones->first();
            });

        $alimentaciones = Alimentacion::with('animal')
            ->latest('fecha')
            ->get();

        $ultimosRegistros = $alimentaciones
            ->groupBy('animal_id')
            ->map(function ($registros) {
                return $registros->first();
            });

        /*
        |--------------------------------------------------------------------------
        | CALCULAR INFORMACIÓN DE CADA ANIMAL
        |--------------------------------------------------------------------------
        */

        $animales->getCollection()->each(function ($animal) use (
            $raciones,
            $reproducciones,
            $ultimosRegistros
        ) {

            $animal->ultimo_registro =
                $ultimosRegistros->get($animal->id);

            /*
            |--------------------------------------------------------------------------
            | ANIMALES VENDIDOS O MUERTOS
            |--------------------------------------------------------------------------
            */

            if (in_array($animal->estado, ['Vendido', 'Muerto'])) {

                $animal->racion_recomendada = null;
                $animal->cantidad_recomendada = null;
                $animal->cantidad_mostrar = null;
                $animal->condicion_reproductiva = null;
                $animal->dias_gestacion = null;

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | RACIÓN AUTOMÁTICA
            |--------------------------------------------------------------------------
            */

            $animal->racion_recomendada = $this->obtenerRacion(
                $animal,
                $raciones,
                $reproducciones
            );

            /*
            |--------------------------------------------------------------------------
            | CANTIDAD AUTOMÁTICA
            |--------------------------------------------------------------------------
            */

            $animal->cantidad_recomendada = $this->obtenerCantidad(
                $animal,
                $raciones,
                $reproducciones
            );

            /*
            |--------------------------------------------------------------------------
            | CANTIDAD QUE SE MOSTRARÁ
            |
            | Si existe ajuste manual:
            |      mostrar cantidad_ajustada
            |
            | Si no existe:
            |      mostrar cantidad_recomendada
            |--------------------------------------------------------------------------
            */

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

            /*
            |--------------------------------------------------------------------------
            | CONDICIÓN REPRODUCTIVA
            |--------------------------------------------------------------------------
            */

            $animal->condicion_reproductiva =
                $this->obtenerCondicionReproductiva(
                    $animal,
                    $reproducciones
                );

            /*
            |--------------------------------------------------------------------------
            | DÍAS DE GESTACIÓN
            |--------------------------------------------------------------------------
            */

            $animal->dias_gestacion =
                $this->obtenerDiasGestacion(
                    $animal,
                    $reproducciones
                );
        });

        return view(
            'alimentacion.index',
            compact(
                'animales',
                'alimentaciones',
                'raciones',
                'reproducciones'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EDITAR REGISTRO DE ALIMENTACIÓN
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $alimentacion = Alimentacion::with('animal')
            ->findOrFail($id);

        $animales = Animal::orderBy('codigo')
            ->get();

        $raciones = Racion::orderBy('etapa')
            ->orderBy('sexo')
            ->orderBy('peso_min')
            ->get();

        $reproducciones = Reproduccion::orderByDesc('fecha_servicio')
            ->get()
            ->groupBy('hembra_id')
            ->map(function ($reproducciones) {
                return $reproducciones->first();
            });

        $animal = $alimentacion->animal;

        $racionRecomendada = $this->obtenerRacion(
            $animal,
            $raciones,
            $reproducciones
        );

        $cantidadRecomendada = $this->obtenerCantidad(
            $animal,
            $raciones,
            $reproducciones
        );

        $condicionReproductiva =
            $this->obtenerCondicionReproductiva(
                $animal,
                $reproducciones
            );

        $diasGestacion =
            $this->obtenerDiasGestacion(
                $animal,
                $reproducciones
            );

        return view(
            'alimentacion.edit',
            compact(
                'alimentacion',
                'animales',
                'raciones',
                'reproducciones',
                'racionRecomendada',
                'cantidadRecomendada',
                'condicionReproductiva',
                'diasGestacion'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR REGISTRO DE ALIMENTACIÓN
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $request->validate([
            'animal_id' => 'required|exists:animales,id',
            'tipo_alimento' => 'required|string',
            'cantidad_suministrada' => 'required|numeric|min:0',
            'fecha' => 'required|date',
            'observaciones' => 'nullable|string'
        ]);

        $alimentacion = Alimentacion::findOrFail($id);

        $alimentacion->update([
            'animal_id' => $request->animal_id,
            'tipo_alimento' => $request->tipo_alimento,
            'cantidad_suministrada' => $request->cantidad_suministrada,
            'fecha' => $request->fecha,
            'observaciones' => $request->observaciones
        ]);

        return redirect()
            ->route('alimentaciones.index')
            ->with(
                'success',
                'Registro de alimentación actualizado correctamente.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | FORMULARIO DE AJUSTE
    |--------------------------------------------------------------------------
    */

    public function editarAjuste($id)
    {
        $animal = Animal::findOrFail($id);

        if ($animal->estado !== 'Activo') {

            return redirect()
                ->route('alimentaciones.index')
                ->with(
                    'error',
                    'No se puede modificar el ajuste de un animal inactivo.'
                );
        }

        $raciones = Racion::orderBy('etapa')
            ->orderBy('sexo')
            ->orderBy('peso_min')
            ->get();

        $reproducciones = Reproduccion::orderByDesc('fecha_servicio')
            ->get()
            ->groupBy('hembra_id')
            ->map(function ($reproducciones) {
                return $reproducciones->first();
            });

        $racionRecomendada = $this->obtenerRacion(
            $animal,
            $raciones,
            $reproducciones
        );

        $cantidadRecomendada = $this->obtenerCantidad(
            $animal,
            $raciones,
            $reproducciones
        );

        $condicionReproductiva =
            $this->obtenerCondicionReproductiva(
                $animal,
                $reproducciones
            );

        $diasGestacion =
            $this->obtenerDiasGestacion(
                $animal,
                $reproducciones
            );

        return view(
            'alimentacion.edit',
            compact(
                'animal',
                'racionRecomendada',
                'cantidadRecomendada',
                'condicionReproductiva',
                'diasGestacion'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | GUARDAR AJUSTE
    |--------------------------------------------------------------------------
    */

    public function actualizarAjuste(Request $request, $id)
    {
        $request->validate([
            'cantidad_ajustada' => [
                'required',
                'numeric',
                'min:0.01'
            ],

            'observacion_alimentacion' => [
                'required',
                'string',
                'max:1000'
            ]
        ], [
            'cantidad_ajustada.required' =>
                'Debe ingresar la cantidad ajustada.',

            'cantidad_ajustada.numeric' =>
                'La cantidad debe ser un número.',

            'cantidad_ajustada.min' =>
                'La cantidad debe ser mayor que 0.',

            'observacion_alimentacion.required' =>
                'Debe registrar el motivo del ajuste.'
        ]);

        $animal = Animal::findOrFail($id);

        if ($animal->estado !== 'Activo') {

            return redirect()
                ->route('alimentaciones.index')
                ->with(
                    'error',
                    'No se puede modificar el ajuste de un animal inactivo.'
                );
        }

        $animal->cantidad_ajustada =
            $request->cantidad_ajustada;

        $animal->observacion_alimentacion =
            $request->observacion_alimentacion;

        $animal->save();

        return redirect()
            ->route('alimentaciones.index')
            ->with(
                'success',
                'Ajuste de alimentación actualizado correctamente.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | MOSTRAR
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $alimentacion = Alimentacion::with('animal')
            ->findOrFail($id);

        return view(
            'alimentacion.show',
            compact('alimentacion')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ELIMINAR
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        Alimentacion::findOrFail($id)->delete();

        return redirect()
            ->route('alimentaciones.index')
            ->with(
                'success',
                'Registro de alimentación eliminado correctamente.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | CONDICIÓN REPRODUCTIVA
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


    /*
    |--------------------------------------------------------------------------
    | DÍAS DE GESTACIÓN
    |--------------------------------------------------------------------------
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

        $dias = Carbon::parse(
            $reproduccion->fecha_servicio
        )->diffInDays(
            Carbon::today()
        ) + 1;

        return $dias;
    }


    /*
    |--------------------------------------------------------------------------
    | OBTENER RACIÓN
    |--------------------------------------------------------------------------
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

        $racion = $raciones->first(
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

        return $racion;
    }


    /*
    |--------------------------------------------------------------------------
    | OBTENER CANTIDAD AUTOMÁTICA
    |--------------------------------------------------------------------------
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