<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('animales', function (Blueprint $table) {
            $table->id();

            // Identificación
            $table->string('codigo')->unique();

            // Datos básicos
            $table->string('raza');

            $table->enum('sexo', [
                'Macho',
                'Hembra'
            ]);

            $table->date('fecha_nacimiento');

            $table->decimal('peso_actual', 8, 2)->default(0);

            // Etapa productiva
            $table->enum('etapa', [
                'Lechon',
                'Levante',
                'Ceba',
                'Reproductor'
            ]);

            // Procedencia
            $table->enum('origen', [
                'Nacido',
                'Comprado'
            ]);

            $table->date('fecha_ingreso')->nullable();

            $table->string('proveedor')->nullable();

            // Estado actual
            $table->enum('estado', [
                'Activo',
                'Vendido',
                'Muerto'
            ])->default('Activo');

            // Granja
            $table->foreignId('granja_id')
                  ->constrained('granjas')
                  ->onDelete('cascade');

            // Genealogía
            $table->unsignedBigInteger('madre_id')->nullable();

            $table->unsignedBigInteger('padre_id')->nullable();

            // Si proviene de inseminación
            $table->string('codigo_genetico')->nullable();

            // Información adicional
            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('animales');
    }
};