<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';

    protected $fillable = [
        'animal_id',
        'cliente',
        'documento_cliente',
        'telefono_cliente',
        'fecha_venta',
        'peso_venta',
        'precio_kilo',
        'total_venta',
        'observaciones'
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }
}