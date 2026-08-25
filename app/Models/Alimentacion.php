<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alimentacion extends Model
{
    protected $table = 'alimentacion';

    protected $fillable = [
        'animal_id',
        'tipo_alimento',
        'cantidad_suministrada',
        'fecha',
        'observaciones'
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }
}