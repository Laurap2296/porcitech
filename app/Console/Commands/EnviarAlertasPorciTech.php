<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Reproduccion;
use App\Models\Sanidad;
use App\Notifications\AlertaPorciTech;
use Carbon\Carbon;

class EnviarAlertasPorciTech extends Command
{
    /**
     * Nombre del comando.
     */
    protected $signature = 'porcitech:alertas';

    /**
     * Descripción.
     */
    protected $description = 'Envía alertas de reproducción y sanidad por correo electrónico';

    /**
     * Ejecutar comando.
     */
    public function handle()
    {
        $this->info('Iniciando revisión de alertas PorciTech...');

        /*
        |--------------------------------------------------------------------------
        | USUARIOS QUE RECIBIRÁN LAS ALERTAS
        |--------------------------------------------------------------------------
        */

        $usuarios = User::whereNotNull('email')
            ->where('email', '!=', '')
            ->where('rol', 'Administrador')
            ->get();

        if ($usuarios->isEmpty()) {

            $this->warn(
                'No existen usuarios Administradores con correo registrado.'
            );

            return Command::SUCCESS;
        }


        /*
        |--------------------------------------------------------------------------
        | FECHA ACTUAL
        |--------------------------------------------------------------------------
        */

        $hoy = Carbon::today();


        /*
        |--------------------------------------------------------------------------
        | ALERTAS DE REPRODUCCIÓN
        |--------------------------------------------------------------------------
        */

        /*
        | Fecha de revisión de celo
        | Se alerta 2 días antes.
        */

        $fechaRevision = $hoy->copy()->addDays(2);

        $revisiones = Reproduccion::with('hembra')
            ->whereDate(
                'fecha_revision_celo',
                $fechaRevision
            )
            ->whereIn(
                'estado',
                ['Servida', 'Gestante']
            )
            ->get();


        foreach ($revisiones as $reproduccion) {

            $codigo = optional($reproduccion->hembra)->codigo
                ?? 'Sin código';

            $mensaje =
                "La cerda {$codigo} tiene programada la "
                . "confirmación de celo para el día "
                . Carbon::parse(
                    $reproduccion->fecha_revision_celo
                )->format('d/m/Y')
                . ". "
                . "La revisión debe realizarse para confirmar "
                . "si presentó repetición de celo.";

            foreach ($usuarios as $usuario) {

                $usuario->notify(
                    new AlertaPorciTech(
                        'Revisión de celo próxima',
                        $mensaje
                    )
                );
            }

            $this->info(
                "Alerta de celo enviada para {$codigo}"
            );
        }


        /*
        |--------------------------------------------------------------------------
        | ALERTAS DE PARTO
        |--------------------------------------------------------------------------
        */

        /*
        | Se alerta 5 días antes de la fecha probable de parto.
        */

        $fechaParto = $hoy->copy()->addDays(5);

        $partos = Reproduccion::with('hembra')
            ->whereDate(
                'fecha_probable_parto',
                $fechaParto
            )
            ->whereIn(
                'estado',
                ['Servida', 'Gestante']
            )
            ->get();


        foreach ($partos as $reproduccion) {

            $codigo = optional($reproduccion->hembra)->codigo
                ?? 'Sin código';

            $mensaje =
                "La cerda {$codigo} tiene una fecha probable "
                . "de parto para el día "
                . Carbon::parse(
                    $reproduccion->fecha_probable_parto
                )->format('d/m/Y')
                . ". "
                . "Se recomienda mantenerla monitoreada "
                . "y preparar las condiciones para el parto.";

            foreach ($usuarios as $usuario) {

                $usuario->notify(
                    new AlertaPorciTech(
                        'Parto próximo',
                        $mensaje
                    )
                );
            }

            $this->info(
                "Alerta de parto enviada para {$codigo}"
            );
        }


        /*
        |--------------------------------------------------------------------------
        | ALERTAS DE SANIDAD
        |--------------------------------------------------------------------------
        */

        /*
        | Se alerta 5 días antes de la próxima fecha sanitaria.
        */

        $fechaSanidad = $hoy->copy()->addDays(5);

        $sanidades = Sanidad::with('animal')
            ->whereDate(
                'proxima_fecha',
                $fechaSanidad
            )
            ->get();


        foreach ($sanidades as $sanidad) {

            $codigo = optional($sanidad->animal)->codigo
                ?? 'Sin código';

            $tipo = $sanidad->tipo_registro;

            $mensaje =
                "El animal {$codigo} tiene programado "
                . "un registro sanitario de tipo {$tipo} "
                . "para el día "
                . Carbon::parse(
                    $sanidad->proxima_fecha
                )->format('d/m/Y')
                . ". "
                . "Actividad: {$sanidad->nombre}.";

            foreach ($usuarios as $usuario) {

                $usuario->notify(
                    new AlertaPorciTech(
                        'Alerta sanitaria próxima',
                        $mensaje
                    )
                );
            }

            $this->info(
                "Alerta sanitaria enviada para {$codigo}"
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FINAL
        |--------------------------------------------------------------------------
        */

        $this->info(
            'Revisión de alertas finalizada correctamente.'
        );

        return Command::SUCCESS;
    }
}