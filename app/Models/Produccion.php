<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produccion extends Model
{
    use HasFactory;

    protected $table = 'produccion';

    protected $fillable = [
        'animal_id',
        'fecha_pesaje',
        'tipo_registro',
        'peso_vivo',
        'peso_canal',
        'resultado',
        'observaciones',
    ];

    protected $casts = [
        'fecha_pesaje' => 'date',
        'peso_vivo' => 'decimal:2',
        'peso_canal' => 'decimal:2',
        'resultado' => 'decimal:2',
    ];

    /**
     * Relación con el animal
     */
    public function animal()
    {
        return $this->belongsTo(Animal::class, 'animal_id');
    }
}