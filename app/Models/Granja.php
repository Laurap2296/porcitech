<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Granja extends Model
{
    protected $fillable = [
        'nombre',
        'ubicacion',
        'propietario',
        'telefono',
        'estado'
    ];

    public function animales()
    {
        return $this->hasMany(Animal::class);
    }
}