<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reproduccion;
use App\Models\Animal;
use App\Models\Pajilla;

class ReproduccionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HISTORIAL REPRODUCTIVO
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $animales = Animal::where('sexo', 'Hembra')
            ->where('etapa', 'Reproductor')
            ->where('estado', 'Activo')
            ->orderBy('codigo')
            ->get();

        $historial = Reproduccion::with(['hembra', 'macho', 'pajilla'])
            ->orderBy('hembra_id')
            ->orderByDesc('fecha_servicio')
            ->get()
            ->groupBy('hembra_id');

        return view('reproducciones.index', compact('animales', 'historial'));
    }

    /*
    |--------------------------------------------------------------------------
    | NUEVA REPRODUCCIÓN
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $ocupadas = Reproduccion::whereIn('estado', ['Servida', 'Gestante'])
            ->pluck('hembra_id');

        $hembras = Animal::where('sexo', 'Hembra')
            ->where('etapa', 'Reproductor')
            ->where('estado', 'Activo')
            ->whereNotIn('id', $ocupadas)
            ->orderBy('codigo')
            ->get();

        $machos = Animal::where('sexo', 'Macho')
            ->where('etapa', 'Reproductor')
            ->where('estado', 'Activo')
            ->orderBy('codigo')
            ->get();

        $pajillas = Pajilla::where('estado', 'Disponible')
            ->orderBy('codigo_pajilla')
            ->get();

        return view('reproducciones.create', compact('hembras', 'machos', 'pajillas'));
    }

    /*
    |--------------------------------------------------------------------------
    | GUARDAR
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'hembra_id' => 'required',
            'tipo_monta' => 'required',
            'fecha_celo' => 'required|date',
            'fecha_servicio' => 'required|date'
        ]);

        $abierta = Reproduccion::where('hembra_id', $request->hembra_id)
            ->whereIn('estado', ['Servida', 'Gestante'])
            ->exists();

        if ($abierta) {
            return back()->withInput()
                ->with('error', 'La cerda ya tiene un ciclo activo.');
        }

        $ultimoServicio = Reproduccion::where('hembra_id', $request->hembra_id)
            ->max('numero_servicio');

        $numeroServicio = $ultimoServicio ? $ultimoServicio + 1 : 1;

        $revision = date('Y-m-d', strtotime($request->fecha_servicio . ' +21 days'));
        $parto = date('Y-m-d', strtotime($request->fecha_servicio . ' +114 days'));

        $macho = null;
        $pajilla = null;

        if ($request->tipo_monta == "Natural") {
            $macho = $request->macho_id;
        } else {
            $pajilla = $request->pajilla_id;

            if ($pajilla) {
                Pajilla::where('id', $pajilla)
                    ->update(['estado' => 'Usada']);
            }
        }

        Reproduccion::create([
            'hembra_id' => $request->hembra_id,
            'tipo_monta' => $request->tipo_monta,
            'macho_id' => $macho,
            'pajilla_id' => $pajilla,
            'fecha_celo' => $request->fecha_celo,
            'numero_servicio' => $numeroServicio,
            'fecha_servicio' => $request->fecha_servicio,
            'fecha_revision_celo' => $revision,
            'repitio_celo' => null,
            'fecha_probable_parto' => $parto,
            'fecha_parto' => null,
            'crias_totales' => null,
            'crias_vivas' => null,
            'crias_muertas' => null,
            'estado' => 'Servida',
            'observaciones' => $request->observaciones
        ]);

        return redirect()->route('reproducciones.index')
            ->with('success', 'Registro creado correctamente.');
    }

    /*
    |--------------------------------------------------------------------------
    | MOSTRAR
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $reproduccion = Reproduccion::with(['hembra', 'macho', 'pajilla'])
            ->findOrFail($id);

        return view('reproducciones.show', compact('reproduccion'));
    }

    /*
    |--------------------------------------------------------------------------
    | EDITAR
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $reproduccion = Reproduccion::findOrFail($id);

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

        $pajillas = Pajilla::orderBy('codigo_pajilla')->get();

        return view('reproducciones.edit', compact(
            'reproduccion',
            'hembras',
            'machos',
            'pajillas'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $reproduccion = Reproduccion::findOrFail($id);

        $request->validate([
            'hembra_id' => 'required',
            'tipo_monta' => 'required',
            'fecha_celo' => 'required|date',
            'fecha_servicio' => 'required|date'
        ]);

        /*
        |--------------------------------------------------------------------------
        | RECALCULAR FECHAS AUTOMÁTICAS
        |--------------------------------------------------------------------------
        |
        | Revisión de celo = 21 días después de la fecha de servicio
        | Parto probable = 114 días después de la fecha de servicio
        |
        */

        $fechaRevision = null;
        $fechaPartoProbable = null;

        if ($request->repitio_celo != "Si") {

            $fechaRevision = date(
                'Y-m-d',
                strtotime($request->fecha_servicio . ' +21 days')
            );

            $fechaPartoProbable = date(
                'Y-m-d',
                strtotime($request->fecha_servicio . ' +114 days')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | DETERMINAR ESTADO
        |--------------------------------------------------------------------------
        */

        $estado = "Servida";

        if ($request->repitio_celo == "Si") {

            $estado = "Fallida";

            $fechaRevision = null;
            $fechaPartoProbable = null;
        }

        if ($request->repitio_celo == "No") {
            $estado = "Gestante";
        }

        if (!empty($request->fecha_parto)) {
            $estado = "Parida";
        }

        /*
        |--------------------------------------------------------------------------
        | MACHO O PAJILLA
        |--------------------------------------------------------------------------
        */

        $macho = null;
        $pajilla = null;

        if ($request->tipo_monta == "Natural") {

            $macho = $request->macho_id;

        } else {

            $pajilla = $request->pajilla_id;

            if ($pajilla) {

                Pajilla::where('id', $pajilla)
                    ->update([
                        'estado' => 'Usada'
                    ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | GENERAR LECHONES
        |--------------------------------------------------------------------------
        */

        if (!empty($request->fecha_parto)) {

            $yaGenerados = Animal::where(
                    'madre_id',
                    $reproduccion->hembra_id
                )
                ->whereDate(
                    'fecha_nacimiento',
                    $request->fecha_parto
                )
                ->exists();

            if (!$yaGenerados) {

                $cantidad = $request->crias_totales ?? 10;

                $granjaId = $reproduccion->hembra->granja_id;

                $razaMadre = $reproduccion->hembra->raza ?? 'Desconocida';

                $razaPadre = $reproduccion->macho->raza ?? 'Desconocido';

                for ($i = 1; $i <= $cantidad; $i++) {

                    Animal::create([
                        'codigo' =>
                            'LC-' .
                            date('Ymd') .
                            '-' .
                            $reproduccion->id .
                            '-' .
                            $i,

                        'fecha_nacimiento' =>
                            $request->fecha_parto,

                        'fecha_ingreso' =>
                            $request->fecha_parto,

                        'etapa' =>
                            'Lechon',

                        'origen' =>
                            'Nacido',

                        'estado' =>
                            'Activo',

                        'madre_id' =>
                            $reproduccion->hembra_id,

                        'padre_id' =>
                            $reproduccion->macho_id,

                        'granja_id' =>
                            $granjaId,

                        'sexo' =>
                            'Pendiente',

                        'peso_actual' =>
                            0.5,

                        'raza' =>
                            $razaMadre . ' x ' . $razaPadre,

                        'proveedor' =>
                            null,

                        'codigo_genetico' =>
                            null,

                        'observaciones' =>
                            'Generado automáticamente desde parto #' .
                            $reproduccion->id,
                    ]);
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE FINAL
        |--------------------------------------------------------------------------
        */

        $reproduccion->update([
            'hembra_id' =>
                $request->hembra_id,

            'tipo_monta' =>
                $request->tipo_monta,

            'macho_id' =>
                $macho,

            'pajilla_id' =>
                $pajilla,

            'fecha_celo' =>
                $request->fecha_celo,

            'fecha_servicio' =>
                $request->fecha_servicio,

            'fecha_revision_celo' =>
                $fechaRevision,

            'repitio_celo' =>
                $request->repitio_celo,

            'fecha_parto' =>
                $request->fecha_parto,

            'fecha_probable_parto' =>
                $fechaPartoProbable,

            'crias_totales' =>
                $request->crias_totales,

            'crias_vivas' =>
                $request->crias_vivas,

            'crias_muertas' =>
                $request->crias_muertas,

            'estado' =>
                $estado,

            'observaciones' =>
                $request->observaciones
        ]);

        return redirect()->route('reproducciones.index')
            ->with('success', 'Registro actualizado correctamente.');
    }

    /*
    |--------------------------------------------------------------------------
    | ELIMINAR
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $reproduccion = Reproduccion::findOrFail($id);

        if ($reproduccion->pajilla_id) {
            Pajilla::where('id', $reproduccion->pajilla_id)
                ->update(['estado' => 'Disponible']);
        }

        $reproduccion->delete();

        return redirect()->route('reproducciones.index')
            ->with('success', 'Registro eliminado correctamente.');
    }
}