<?php

namespace App\Http\Controllers;

use App\Models\Sanidad;
use App\Models\Animal;
use Illuminate\Http\Request;

class SanidadController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LISTADO / HISTORIAL DE SANIDAD
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $animales = Animal::whereHas('sanidades')
            ->orderBy('codigo')
            ->get();

        $historial = Sanidad::with('animal')
            ->orderBy('animal_id')
            ->orderByDesc('fecha')
            ->get()
            ->groupBy('animal_id');

        return view(
            'sanidad.index',
            compact(
                'animales',
                'historial'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CREAR REGISTRO
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $animales = Animal::where('estado', 'Activo')
            ->orderBy('codigo')
            ->get();

        return view(
            'sanidad.create',
            compact('animales')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | GUARDAR REGISTRO
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'animal_id' => 'required',
            'tipo_registro' => 'required',
            'nombre' => 'required',
            'fecha' => 'required'
        ]);

        $fecha = $request->fecha;

        $proxima = $request->proxima_fecha;


        /*
        |--------------------------------------------------------------------------
        | CREAR REGISTRO
        |--------------------------------------------------------------------------
        */

        Sanidad::create([

            'animal_id' => $request->animal_id,

            'tipo_registro' => $request->tipo_registro,

            'nombre' => $request->nombre,

            'fecha' => $fecha,

            'proxima_fecha' => $proxima,

            'diagnostico' => $request->diagnostico,

            'observaciones' => $request->observaciones

        ]);


        return redirect()
            ->route('sanidades.index')
            ->with(
                'success',
                'Registro creado correctamente'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | VER REGISTRO
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $sanidad = Sanidad::with('animal')
            ->findOrFail($id);

        return view(
            'sanidad.show',
            compact('sanidad')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EDITAR REGISTRO
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $sanidad = Sanidad::findOrFail($id);

        $animales = Animal::where('estado', 'Activo')
            ->orderBy('codigo')
            ->get();

        if (
            $sanidad->animal &&
            !$animales->contains('id', $sanidad->animal_id)
        ) {

            $animales->push($sanidad->animal);

            $animales = $animales
                ->sortBy('codigo')
                ->values();
        }


        return view(
            'sanidad.edit',
            compact(
                'sanidad',
                'animales'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR REGISTRO
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $sanidad = Sanidad::findOrFail($id);

        $request->validate([
            'animal_id' => 'required',
            'tipo_registro' => 'required',
            'nombre' => 'required',
            'fecha' => 'required'
        ]);


        $fecha = $request->fecha;

        $proxima = $request->proxima_fecha;


        /*
        |--------------------------------------------------------------------------
        | ACTUALIZAR
        |--------------------------------------------------------------------------
        */

        $sanidad->update([

            'animal_id' => $request->animal_id,

            'tipo_registro' => $request->tipo_registro,

            'nombre' => $request->nombre,

            'fecha' => $fecha,

            'proxima_fecha' => $proxima,

            'diagnostico' => $request->diagnostico,

            'observaciones' => $request->observaciones

        ]);


        return redirect()
            ->route('sanidades.index')
            ->with(
                'success',
                'Registro actualizado correctamente'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | ELIMINAR
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        Sanidad::findOrFail($id)->delete();

        return redirect()
            ->route('sanidades.index')
            ->with(
                'success',
                'Registro eliminado correctamente'
            );
    }
}