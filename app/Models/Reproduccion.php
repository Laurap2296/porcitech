<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reproduccion extends Model
{
    protected $table = 'reproduccion';

    protected $fillable = [
        'hembra_id',
        'tipo_monta',
        'macho_id',
        'pajilla_id',
        'fecha_celo',
        'numero_servicio',
        'fecha_servicio',
        'fecha_probable_parto',
        'fecha_parto',
        'crias_totales',
        'crias_vivas',
        'crias_muertas',
        'estado',
        'observaciones'
    ];

    public function hembra()
    {
        return $this->belongsTo(Animal::class, 'hembra_id');
    }

    public function macho()
    {
        return $this->belongsTo(Animal::class, 'macho_id');
    }

    public function pajilla()
    {
        return $this->belongsTo(Pajilla::class, 'pajilla_id');
    }
}