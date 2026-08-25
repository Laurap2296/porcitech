<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pajilla extends Model
{
    protected $table = 'pajillas';

    protected $fillable = [
        'codigo_pajilla',
        'raza',
        'linea_genetica',
        'proveedor',
        'fecha_recoleccion',
        'estado',
        'observaciones'
    ];

    public function reproducciones()
    {
        return $this->hasMany(Reproduccion::class);
    }
}