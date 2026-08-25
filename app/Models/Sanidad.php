<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sanidad extends Model
{
    use HasFactory;

    protected $table = 'sanidad';

    protected $fillable = [
        'animal_id',
        'tipo_registro',
        'nombre',
        'fecha',
        'proxima_fecha',
        'diagnostico',
        'observaciones',
        'tipo_duracion',
        'fecha_inicio',
        'fecha_fin',
        'frecuencia_dias'
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }
}