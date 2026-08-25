<?php

namespace App\Http\Controllers;

use App\Models\Granja;
use Illuminate\Http\Request;

class GranjaController extends Controller
{
    public function index()
    {
        $granjas = Granja::all();

        return view('granjas.index', compact('granjas'));
    }

    public function create()
    {
        return view('granjas.create');
    }

    public function store(Request $request)
    {
        Granja::create($request->all());

        return redirect()->route('granjas.index')
            ->with('success', 'Granja registrada correctamente');
    }

    public function show(Granja $granja)
    {
        return view('granjas.show', compact('granja'));
    }

    public function edit(Granja $granja)
    {
        return view('granjas.edit', compact('granja'));
    }

    public function update(Request $request, Granja $granja)
    {
        $granja->update($request->all());

        return redirect()->route('granjas.index')
            ->with('success', 'Granja actualizada correctamente');
    }

    public function destroy(Granja $granja)
    {
        $granja->delete();

        return redirect()->route('granjas.index')
            ->with('success', 'Granja eliminada correctamente');
    }
}