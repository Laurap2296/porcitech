<?php

namespace App\Http\Controllers;

use App\Models\Pajilla;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PajillaController extends Controller
{
    public function index()
    {
        $pajillas = Pajilla::all();

        return view('pajillas.index', compact('pajillas'));
    }

    public function create()
    {
        return view('pajillas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo_pajilla' => [
                'required',
                'unique:pajillas,codigo_pajilla',
            ],
        ], [
            'codigo_pajilla.required' => 'El código de la pajilla es obligatorio.',
            'codigo_pajilla.unique' => 'El código de pajilla ya está registrado. Ingrese uno diferente.',
        ]);

        Pajilla::create($request->all());

        return redirect()
            ->route('pajillas.index')
            ->with('success', 'Pajilla registrada correctamente');
    }

    public function show(Pajilla $pajilla)
    {
        return view('pajillas.show', compact('pajilla'));
    }

    public function edit(Pajilla $pajilla)
    {
        return view('pajillas.edit', compact('pajilla'));
    }

    public function update(Request $request, Pajilla $pajilla)
    {
        $request->validate([
            'codigo_pajilla' => [
                'required',
                Rule::unique('pajillas', 'codigo_pajilla')
                    ->ignore($pajilla->id),
            ],
        ], [
            'codigo_pajilla.required' => 'El código de la pajilla es obligatorio.',
            'codigo_pajilla.unique' => 'El código de pajilla ya está registrado. Ingrese uno diferente.',
        ]);

        $pajilla->update($request->all());

        return redirect()
            ->route('pajillas.index')
            ->with('success', 'Pajilla actualizada correctamente');
    }

    public function destroy(Pajilla $pajilla)
    {
        $pajilla->delete();

        return redirect()
            ->route('pajillas.index')
            ->with('success', 'Pajilla eliminada correctamente');
    }
}