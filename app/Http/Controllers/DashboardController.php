<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;
use App\Models\Granja;
use App\Models\Reproduccion;

class DashboardController extends Controller
{
    public function index()
    {
        $animales = Animal::count();
        $granjas = Granja::count();
        $reproducciones = Reproduccion::count();

        return view('dashboard', compact(
            'animales',
            'granjas',
            'reproducciones'
        ));
    }
}