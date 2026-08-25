<?php

namespace App\Http\Controllers;

use App\Models\Pajilla;
use Illuminate\Http\Request;

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