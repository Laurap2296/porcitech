<?php

namespace App\Http\Controllers;

use App\Models\Produccion;
use App\Models\Animal;
use Illuminate\Http\Request;

class ProduccionController extends Controller
{
    /**
     * =========================================================
     * INDEX
     * =========================================================
     */
    public function index()
    {
        $producciones = Produccion::with('animal')
            ->orderBy('animal_id')
            ->orderBy('fecha_pesaje')
            ->get()
            ->groupBy('animal_id');

        /*
        |--------------------------------------------------------------------------
        | SOLO ANIMALES ACTIVOS
        |--------------------------------------------------------------------------
        | Los animales vendidos o muertos no pueden recibir
        | nuevos registros de producción.
        */
        $animales = Animal::where('estado', 'Activo')
            ->orderBy('codigo')
            ->get();

        return view(
            'produccion.index',
            compact('producciones', 'animales')
        );
    }


    /**
     * =========================================================
     * STORE
     * =========================================================
     */
    public function store(Request $request)
    {
        $request->validate([
            'animal_id' => 'required|exists:animales,id',
            'fecha_pesaje' => 'required|date',

            /*
            |--------------------------------------------------------------------------
            | TIPOS DE REGISTRO
            |--------------------------------------------------------------------------
            |
            | mensual    = pesaje normal
            | sacrificio = sacrificio para producción de carne
            | muerto     = muerte por enfermedad, accidente, etc.
            |
            */
            'tipo_registro' => 'required|in:mensual,sacrificio,muerto',

            'peso_vivo' => 'nullable|numeric|min:0',
            'peso_canal' => 'nullable|numeric|min:0',
            'observaciones' => 'nullable|string',
        ]);


        /*
        |--------------------------------------------------------------------------
        | BUSCAR ANIMAL
        |--------------------------------------------------------------------------
        */
        $animal = Animal::findOrFail($request->animal_id);


        /*
        |--------------------------------------------------------------------------
        | SEGURIDAD
        |--------------------------------------------------------------------------
        | Un animal vendido o muerto no puede recibir nuevos registros.
        */
        if (in_array($animal->estado, ['Vendido', 'Muerto'])) {

            return redirect()
                ->route('producciones.index')
                ->withErrors([
                    'animal_id' =>
                        'El animal seleccionado ya se encuentra '
                        . strtolower($animal->estado)
                        . ' y no puede recibir nuevos registros de producción.'
                ]);
        }


        $resultado = null;


        /*
        |--------------------------------------------------------------------------
        | MENSUAL
        |--------------------------------------------------------------------------
        | Calcula la ganancia de peso respecto al último pesaje mensual.
        */
        if ($request->tipo_registro === 'mensual') {

            $ultimo = Produccion::where(
                    'animal_id',
                    $request->animal_id
                )
                ->where('tipo_registro', 'mensual')
                ->orderBy('fecha_pesaje', 'desc')
                ->first();


            if (
                $ultimo &&
                $request->peso_vivo !== null &&
                $ultimo->peso_vivo !== null
            ) {

                $resultado =
                    $request->peso_vivo - $ultimo->peso_vivo;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | SACRIFICIO
        |--------------------------------------------------------------------------
        | Calcula el rendimiento de canal.
        |
        | peso canal / peso vivo * 100
        |
        | Al finalizar el sacrificio el animal pasa a:
        |
        | VENDIDO
        |
        */
        if ($request->tipo_registro === 'sacrificio') {

            if (
                $request->peso_vivo !== null &&
                $request->peso_canal !== null &&
                $request->peso_vivo > 0
            ) {

                $resultado =
                    ($request->peso_canal / $request->peso_vivo) * 100;
            }


            /*
            |--------------------------------------------------------------------------
            | ACTUALIZAR ESTADO
            |--------------------------------------------------------------------------
            */
            $animal->estado = 'Vendido';
            $animal->save();
        }


        /*
        |--------------------------------------------------------------------------
        | MUERTO
        |--------------------------------------------------------------------------
        | Muerte por enfermedad, accidente u otra causa.
        |
        | No calcula rendimiento.
        */
        if ($request->tipo_registro === 'muerto') {

            $resultado = null;


            /*
            |--------------------------------------------------------------------------
            | ACTUALIZAR ESTADO
            |--------------------------------------------------------------------------
            */
            $animal->estado = 'Muerto';
            $animal->save();
        }


        /*
        |--------------------------------------------------------------------------
        | GUARDAR PRODUCCIÓN
        |--------------------------------------------------------------------------
        */
        Produccion::create([
            'animal_id' => $request->animal_id,
            'fecha_pesaje' => $request->fecha_pesaje,
            'tipo_registro' => $request->tipo_registro,
            'peso_vivo' => $request->peso_vivo,
            'peso_canal' => $request->peso_canal,
            'resultado' => $resultado,
            'observaciones' => $request->observaciones,
        ]);


        return redirect()
            ->route('producciones.index')
            ->with(
                'success',
                'Registro de producción guardado correctamente.'
            );
    }


    /**
     * =========================================================
     * EDIT
     * =========================================================
     */
    public function edit($id)
    {
        $produccion = Produccion::with('animal')
            ->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | ACTIVOS + ANIMAL DEL REGISTRO
        |--------------------------------------------------------------------------
        | Se mantiene el animal actual para poder editar su historial.
        */
        $animales = Animal::where('estado', 'Activo')
            ->orWhere('id', $produccion->animal_id)
            ->orderBy('codigo')
            ->get();


        return view(
            'produccion.edit',
            compact('produccion', 'animales')
        );
    }


    /**
     * =========================================================
     * UPDATE
     * =========================================================
     */
    public function update(Request $request, $id)
    {
        $produccion = Produccion::findOrFail($id);


        $request->validate([
            'animal_id' => 'required|exists:animales,id',
            'fecha_pesaje' => 'required|date',
            'tipo_registro' => 'required|in:mensual,sacrificio,muerto',
            'peso_vivo' => 'nullable|numeric|min:0',
            'peso_canal' => 'nullable|numeric|min:0',
            'observaciones' => 'nullable|string',
        ]);


        /*
        |--------------------------------------------------------------------------
        | ANIMALES
        |--------------------------------------------------------------------------
        */
        $animalAnterior = Animal::find($produccion->animal_id);

        $nuevoAnimal = Animal::findOrFail(
            $request->animal_id
        );


        $resultado = null;


        /*
        |--------------------------------------------------------------------------
        | MENSUAL
        |--------------------------------------------------------------------------
        */
        if ($request->tipo_registro === 'mensual') {

            $ultimo = Produccion::where(
                    'animal_id',
                    $request->animal_id
                )
                ->where('tipo_registro', 'mensual')
                ->where('id', '!=', $produccion->id)
                ->where(
                    'fecha_pesaje',
                    '<=',
                    $request->fecha_pesaje
                )
                ->orderBy('fecha_pesaje', 'desc')
                ->first();


            if (
                $ultimo &&
                $request->peso_vivo !== null &&
                $ultimo->peso_vivo !== null
            ) {

                $resultado =
                    $request->peso_vivo - $ultimo->peso_vivo;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | SACRIFICIO
        |--------------------------------------------------------------------------
        */
        if ($request->tipo_registro === 'sacrificio') {

            if (
                $request->peso_vivo !== null &&
                $request->peso_canal !== null &&
                $request->peso_vivo > 0
            ) {

                $resultado =
                    ($request->peso_canal / $request->peso_vivo) * 100;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | MUERTO
        |--------------------------------------------------------------------------
        */
        if ($request->tipo_registro === 'muerto') {

            $resultado = null;
        }


        /*
        |--------------------------------------------------------------------------
        | ACTUALIZAR REGISTRO
        |--------------------------------------------------------------------------
        */
        $produccion->update([
            'animal_id' => $request->animal_id,
            'fecha_pesaje' => $request->fecha_pesaje,
            'tipo_registro' => $request->tipo_registro,
            'peso_vivo' => $request->peso_vivo,
            'peso_canal' => $request->peso_canal,
            'resultado' => $resultado,
            'observaciones' => $request->observaciones,
        ]);


        /*
        |--------------------------------------------------------------------------
        | ACTUALIZAR ESTADO DEL ANIMAL
        |--------------------------------------------------------------------------
        |
        | Sacrificio → Vendido
        | Muerto → Muerto
        | Mensual → Activo
        |
        */
        if ($request->tipo_registro === 'sacrificio') {

            $nuevoAnimal->estado = 'Vendido';
            $nuevoAnimal->save();

        } elseif ($request->tipo_registro === 'muerto') {

            $nuevoAnimal->estado = 'Muerto';
            $nuevoAnimal->save();

        } else {

            /*
            |--------------------------------------------------------------------------
            | MENSUAL
            |--------------------------------------------------------------------------
            | Antes de devolver a Activo comprobamos si existe
            | otro registro de sacrificio o muerte.
            */
            $tieneSalida = Produccion::where(
                    'animal_id',
                    $nuevoAnimal->id
                )
                ->whereIn(
                    'tipo_registro',
                    ['sacrificio', 'muerto']
                )
                ->exists();


            if (!$tieneSalida) {

                $nuevoAnimal->estado = 'Activo';
                $nuevoAnimal->save();
            }
        }


        /*
        |--------------------------------------------------------------------------
        | SI CAMBIÓ EL ANIMAL DEL REGISTRO
        |--------------------------------------------------------------------------
        */
        if (
            $animalAnterior &&
            $animalAnterior->id !== $nuevoAnimal->id
        ) {

            /*
            |--------------------------------------------------------------------------
            | REVISAR HISTORIAL DEL ANIMAL ANTERIOR
            |--------------------------------------------------------------------------
            */
            $salidaAnterior = Produccion::where(
                    'animal_id',
                    $animalAnterior->id
                )
                ->whereIn(
                    'tipo_registro',
                    ['sacrificio', 'muerto']
                )
                ->exists();


            /*
            |--------------------------------------------------------------------------
            | SI YA NO TIENE SACRIFICIO NI MUERTE
            |--------------------------------------------------------------------------
            */
            if (!$salidaAnterior) {

                $animalAnterior->estado = 'Activo';
                $animalAnterior->save();
            }
        }


        return redirect()
            ->route('producciones.index')
            ->with(
                'success',
                'Registro de producción actualizado correctamente.'
            );
    }


    /**
     * =========================================================
     * DESTROY
     * =========================================================
     */
    public function destroy($id)
    {
        $produccion = Produccion::findOrFail($id);


        $animal = Animal::find(
            $produccion->animal_id
        );


        /*
        |--------------------------------------------------------------------------
        | ELIMINAR REGISTRO
        |--------------------------------------------------------------------------
        */
        $produccion->delete();


        /*
        |--------------------------------------------------------------------------
        | REVISAR HISTORIAL DEL ANIMAL
        |--------------------------------------------------------------------------
        */
        if ($animal) {

            $registroSacrificio = Produccion::where(
                    'animal_id',
                    $animal->id
                )
                ->where(
                    'tipo_registro',
                    'sacrificio'
                )
                ->exists();


            $registroMuerto = Produccion::where(
                    'animal_id',
                    $animal->id
                )
                ->where(
                    'tipo_registro',
                    'muerto'
                )
                ->exists();


            /*
            |--------------------------------------------------------------------------
            | SI EXISTE SACRIFICIO
            |--------------------------------------------------------------------------
            | El animal continúa vendido.
            */
            if ($registroSacrificio) {

                $animal->estado = 'Vendido';
                $animal->save();
            }


            /*
            |--------------------------------------------------------------------------
            | SI EXISTE MUERTO Y NO SACRIFICIO
            |--------------------------------------------------------------------------
            | El animal continúa muerto.
            */
            elseif ($registroMuerto) {

                $animal->estado = 'Muerto';
                $animal->save();
            }


            /*
            |--------------------------------------------------------------------------
            | SI YA NO EXISTE SALIDA
            |--------------------------------------------------------------------------
            | Puede volver a estar activo.
            */
            else {

                $animal->estado = 'Activo';
                $animal->save();
            }
        }


        return redirect()
            ->route('producciones.index')
            ->with(
                'success',
                'Registro de producción eliminado correctamente.'
            );
    }
}