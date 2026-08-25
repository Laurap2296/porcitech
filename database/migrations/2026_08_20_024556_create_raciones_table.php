<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crear tabla de raciones
     */
    public function up(): void
    {
        Schema::create('raciones', function (Blueprint $table) {

            $table->id();

            // Nombre de la regla de alimentación
            $table->string('nombre');

            // Etapa del animal
            $table->enum('etapa', [
                'Lechon',
                'Levante',
                'Ceba',
                'Reproductor'
            ]);

            // Sexo del animal
            $table->enum('sexo', [
                'Macho',
                'Hembra',
                'Ambos'
            ])->default('Ambos');

            // Condición especial
            // Normal, Gestante, Lactante, Servicio, etc.
            $table->string('condicion')->nullable();

            // Rango de peso
            $table->decimal('peso_min', 8, 2)->nullable();
            $table->decimal('peso_max', 8, 2)->nullable();

            // Rango de días de gestación
            $table->integer('dias_gestacion_min')->nullable();
            $table->integer('dias_gestacion_max')->nullable();

            // Cantidad recomendada
            $table->decimal('cantidad_min', 8, 2);
            $table->decimal('cantidad_max', 8, 2);

            // Tipo de alimento
            $table->string('tipo_alimento');

            // Información adicional
            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Eliminar tabla
     */
    public function down(): void
    {
        Schema::dropIfExists('raciones');
    }
};