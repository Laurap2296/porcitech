<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Racion extends Model
{
    protected $table = 'raciones';

    protected $fillable = [
        'nombre',
        'etapa',
        'sexo',
        'condicion',
        'peso_min',
        'peso_max',
        'dias_gestacion_min',
        'dias_gestacion_max',
        'cantidad_min',
        'cantidad_max',
        'tipo_alimento',
        'observaciones'
    ];
}