<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Granja;
use App\Models\Alimentacion;
use App\Models\Produccion;
use App\Models\Sanidad;
use App\Models\Venta;
use App\Models\Reproduccion;

class Animal extends Model
{
    protected $table = 'animales';

    protected $fillable = [
        'codigo',
        'raza',
        'sexo',
        'fecha_nacimiento',
        'peso_actual',
        'etapa',
        'origen',
        'fecha_ingreso',
        'proveedor',
        'estado',
        'granja_id',
        'madre_id',
        'padre_id',
        'codigo_genetico',
        'observaciones'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIÓN CON GRANJA
    |--------------------------------------------------------------------------
    */

    public function granja()
    {
        return $this->belongsTo(Granja::class);
    }

    /*
    |--------------------------------------------------------------------------
    | ALIMENTACIÓN
    |--------------------------------------------------------------------------
    */

    public function alimentaciones()
    {
        return $this->hasMany(Alimentacion::class, 'animal_id');
    }

    /*
    |--------------------------------------------------------------------------
    | PRODUCCIÓN
    |--------------------------------------------------------------------------
    */

    public function producciones()
    {
        return $this->hasMany(Produccion::class, 'animal_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SANIDAD
    |--------------------------------------------------------------------------
    */

    public function sanidades()
    {
        return $this->hasMany(Sanidad::class, 'animal_id');
    }

    /*
    |--------------------------------------------------------------------------
    | VENTAS
    |--------------------------------------------------------------------------
    */

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'animal_id');
    }

    /*
    |--------------------------------------------------------------------------
    | REPRODUCCIÓN COMO HEMBRA
    |--------------------------------------------------------------------------
    */

    public function reproduccionesHembra()
    {
        return $this->hasMany(Reproduccion::class, 'hembra_id');
    }

    /*
    |--------------------------------------------------------------------------
    | REPRODUCCIÓN COMO MACHO
    |--------------------------------------------------------------------------
    */

    public function reproduccionesMacho()
    {
        return $this->hasMany(Reproduccion::class, 'macho_id');
    }
}