<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Animal;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::with('animal')->get();

        return view('ventas.index', compact('ventas'));
    }

    public function create()
    {
        $animales = Animal::where('estado', 'Activo')->get();

        return view('ventas.create', compact('animales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'animal_id' => 'required',
            'cliente' => 'required',
            'fecha_venta' => 'required',
            'peso_venta' => 'required|numeric',
            'precio_kilo' => 'required|numeric',
        ]);

        $total = $request->peso_venta * $request->precio_kilo;

        Venta::create([
            'animal_id' => $request->animal_id,
            'cliente' => $request->cliente,
            'documento_cliente' => $request->documento_cliente,
            'telefono_cliente' => $request->telefono_cliente,
            'fecha_venta' => $request->fecha_venta,
            'peso_venta' => $request->peso_venta,
            'precio_kilo' => $request->precio_kilo,
            'total_venta' => $total,
            'observaciones' => $request->observaciones,
        ]);

        Animal::find($request->animal_id)
            ->update(['estado' => 'Vendido']);

        return redirect()->route('ventas.index')
            ->with('success', 'Venta registrada correctamente.');
    }

    public function show(string $id)
    {
        $venta = Venta::with('animal')->findOrFail($id);

        return view('ventas.show', compact('venta'));
    }

    public function edit(string $id)
    {
        $venta = Venta::findOrFail($id);

        $animales = Animal::all();

        return view('ventas.edit', compact('venta', 'animales'));
    }

    public function update(Request $request, string $id)
    {
        $venta = Venta::findOrFail($id);

        $total = $request->peso_venta * $request->precio_kilo;

        $venta->update([
            'animal_id' => $request->animal_id,
            'cliente' => $request->cliente,
            'documento_cliente' => $request->documento_cliente,
            'telefono_cliente' => $request->telefono_cliente,
            'fecha_venta' => $request->fecha_venta,
            'peso_venta' => $request->peso_venta,
            'precio_kilo' => $request->precio_kilo,
            'total_venta' => $total,
            'observaciones' => $request->observaciones,
        ]);

        return redirect()->route('ventas.index')
            ->with('success', 'Venta actualizada correctamente.');
    }

    public function destroy(string $id)
    {
        Venta::findOrFail($id)->delete();

        return redirect()->route('ventas.index')
            ->with('success', 'Venta eliminada correctamente.');
    }
}