<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Racion;

class RacionSeeder extends Seeder
{
    public function run(): void
    {
        Racion::insert([

            /*
            |--------------------------------------------------------------------------
            | CERDAS GESTANTES
            |--------------------------------------------------------------------------
            */

            [
                'nombre' => 'Cerda gestante - días 1 a 90',
                'etapa' => 'Reproductor',
                'sexo' => 'Hembra',
                'condicion' => 'Gestante',
                'peso_min' => null,
                'peso_max' => null,
                'dias_gestacion_min' => 1,
                'dias_gestacion_max' => 90,
                'cantidad_min' => 2.00,
                'cantidad_max' => 2.00,
                'tipo_alimento' => 'Alimento para gestación',
                'observaciones' => 'Ración promedio de 2 kg diarios. Ajustar según condición corporal.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nombre' => 'Cerda gestante - días 91 a 110',
                'etapa' => 'Reproductor',
                'sexo' => 'Hembra',
                'condicion' => 'Gestante',
                'peso_min' => null,
                'peso_max' => null,
                'dias_gestacion_min' => 91,
                'dias_gestacion_max' => 110,
                'cantidad_min' => 2.50,
                'cantidad_max' => 3.00,
                'tipo_alimento' => 'Alimento para gestación',
                'observaciones' => 'Ración entre 2,5 y 3 kg diarios según condición corporal.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nombre' => 'Cerda gestante - días 111 a 115',
                'etapa' => 'Reproductor',
                'sexo' => 'Hembra',
                'condicion' => 'Gestante',
                'peso_min' => null,
                'peso_max' => null,
                'dias_gestacion_min' => 111,
                'dias_gestacion_max' => 115,
                'cantidad_min' => 4.00,
                'cantidad_max' => 4.00,
                'tipo_alimento' => 'Alimento para gestación',
                'observaciones' => 'Ración de 4 kg diarios. Puede dividirse en varias comidas.',
                'created_at' => now(),
                'updated_at' => now(),
            ],


            /*
            |--------------------------------------------------------------------------
            | CERDA LACTANTE
            |--------------------------------------------------------------------------
            */

            [
                'nombre' => 'Cerda lactante',
                'etapa' => 'Reproductor',
                'sexo' => 'Hembra',
                'condicion' => 'Lactante',
                'peso_min' => null,
                'peso_max' => null,
                'dias_gestacion_min' => null,
                'dias_gestacion_max' => null,
                'cantidad_min' => 2.50,
                'cantidad_max' => 2.50,
                'tipo_alimento' => 'Alimento para lactancia',
                'observaciones' => 'Base de 2,5 kg diarios más 0,5 kg por cada lechón lactante.',
                'created_at' => now(),
                'updated_at' => now(),
            ],


            /*
            |--------------------------------------------------------------------------
            | CERDA VACÍA / DESTETE - SERVICIO
            |--------------------------------------------------------------------------
            */

            [
                'nombre' => 'Cerda vacía - destete a servicio',
                'etapa' => 'Reproductor',
                'sexo' => 'Hembra',
                'condicion' => 'Vacia',
                'peso_min' => null,
                'peso_max' => null,
                'dias_gestacion_min' => null,
                'dias_gestacion_max' => null,
                'cantidad_min' => 2.50,
                'cantidad_max' => 3.20,
                'tipo_alimento' => 'Alimento para lactancia/reproducción',
                'observaciones' => 'Ración de referencia para el periodo entre destete y servicio.',
                'created_at' => now(),
                'updated_at' => now(),
            ],


            /*
            |--------------------------------------------------------------------------
            | VERRACO
            |--------------------------------------------------------------------------
            */

            [
                'nombre' => 'Verraco en reposo',
                'etapa' => 'Reproductor',
                'sexo' => 'Macho',
                'condicion' => 'Reposo',
                'peso_min' => null,
                'peso_max' => null,
                'dias_gestacion_min' => null,
                'dias_gestacion_max' => null,
                'cantidad_min' => 2.00,
                'cantidad_max' => 3.00,
                'tipo_alimento' => 'Alimento para reproductores',
                'observaciones' => 'Ración de referencia para verracos en reposo.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nombre' => 'Verraco en servicio',
                'etapa' => 'Reproductor',
                'sexo' => 'Macho',
                'condicion' => 'Servicio',
                'peso_min' => null,
                'peso_max' => null,
                'dias_gestacion_min' => null,
                'dias_gestacion_max' => null,
                'cantidad_min' => 3.00,
                'cantidad_max' => 3.50,
                'tipo_alimento' => 'Alimento para reproductores',
                'observaciones' => 'Ración de referencia para verracos en servicio.',
                'created_at' => now(),
                'updated_at' => now(),
            ],


            /*
            |--------------------------------------------------------------------------
            | REPRODUCTOR HEMBRA - NORMAL
            |--------------------------------------------------------------------------
            */

            [
                'nombre' => 'Hembra reproductora en mantenimiento',
                'etapa' => 'Reproductor',
                'sexo' => 'Hembra',
                'condicion' => 'Mantenimiento',
                'peso_min' => null,
                'peso_max' => null,
                'dias_gestacion_min' => null,
                'dias_gestacion_max' => null,
                'cantidad_min' => 2.00,
                'cantidad_max' => 3.00,
                'tipo_alimento' => 'Alimento para reproductoras',
                'observaciones' => 'Ajustar según condición corporal y estado reproductivo.',
                'created_at' => now(),
                'updated_at' => now(),
            ],


            /*
            |--------------------------------------------------------------------------
            | LEVANTE
            |--------------------------------------------------------------------------
            */

            [
                'nombre' => 'Levante',
                'etapa' => 'Levante',
                'sexo' => 'Ambos',
                'condicion' => 'Normal',
                'peso_min' => 25.00,
                'peso_max' => 60.00,
                'dias_gestacion_min' => null,
                'dias_gestacion_max' => null,
                'cantidad_min' => 1.50,
                'cantidad_max' => 2.00,
                'tipo_alimento' => 'Alimento de levante',
                'observaciones' => 'Ración provisional de referencia. Debe ajustarse según peso y programa nutricional.',
                'created_at' => now(),
                'updated_at' => now(),
            ],


            /*
            |--------------------------------------------------------------------------
            | CEBA
            |--------------------------------------------------------------------------
            */

            [
                'nombre' => 'Ceba',
                'etapa' => 'Ceba',
                'sexo' => 'Ambos',
                'condicion' => 'Normal',
                'peso_min' => 60.00,
                'peso_max' => 120.00,
                'dias_gestacion_min' => null,
                'dias_gestacion_max' => null,
                'cantidad_min' => 2.00,
                'cantidad_max' => 3.00,
                'tipo_alimento' => 'Alimento de ceba',
                'observaciones' => 'Ración provisional de referencia. Debe ajustarse según peso, genética y programa nutricional.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
                        /*
            |--------------------------------------------------------------------------
            | LECHONES
            |--------------------------------------------------------------------------
            */

            [
                'nombre' => 'Lechón - inicio',
                'etapa' => 'Lechon',
                'sexo' => 'Ambos',
                'condicion' => 'Normal',
                'peso_min' => 0.50,
                'peso_max' => 5.00,
                'dias_gestacion_min' => null,
                'dias_gestacion_max' => null,
                'cantidad_min' => 0.10,
                'cantidad_max' => 0.20,
                'tipo_alimento' => 'Alimento preiniciador',
                'observaciones' => 'Ración de referencia para lechones jóvenes. Ajustar según edad, peso y consumo.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nombre' => 'Lechón - crecimiento inicial',
                'etapa' => 'Lechon',
                'sexo' => 'Ambos',
                'condicion' => 'Normal',
                'peso_min' => 5.01,
                'peso_max' => 10.00,
                'dias_gestacion_min' => null,
                'dias_gestacion_max' => null,
                'cantidad_min' => 0.20,
                'cantidad_max' => 0.40,
                'tipo_alimento' => 'Alimento iniciador',
                'observaciones' => 'Aumentar gradualmente según consumo y desarrollo.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            /*
            |--------------------------------------------------------------------------
            | CEBA MAYOR A 120 KG
            |--------------------------------------------------------------------------
            */

            [
                'nombre' => 'Ceba - animales mayores',
                'etapa' => 'Ceba',
                'sexo' => 'Ambos',
                'condicion' => 'Normal',
                'peso_min' => 120.01,
                'peso_max' => 180.00,
                'dias_gestacion_min' => null,
                'dias_gestacion_max' => null,
                'cantidad_min' => 2.50,
                'cantidad_max' => 3.20,
                'tipo_alimento' => 'Alimento de ceba',
                'observaciones' => 'Ración de referencia para animales de mayor peso.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}