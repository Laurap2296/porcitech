<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reproduccion', function (Blueprint $table) {

            $table->id();

            // Cerda reproductora
            $table->foreignId('hembra_id')
                  ->constrained('animales')
                  ->onDelete('cascade');

            // Natural o inseminación
            $table->enum('tipo_monta', [
                'Natural',
                'Inseminacion'
            ]);

            // Solo si es monta natural
            $table->foreignId('macho_id')
                  ->nullable()
                  ->constrained('animales')
                  ->nullOnDelete();

            // Solo si es inseminación
            $table->foreignId('pajilla_id')
                  ->nullable()
                  ->constrained('pajillas')
                  ->nullOnDelete();

            // Control reproductivo
            $table->date('fecha_celo');

            $table->integer('numero_servicio')->default(1);

            $table->date('fecha_servicio');

            $table->date('fecha_probable_parto')->nullable();

            $table->date('fecha_parto')->nullable();

            // Resultado del parto
            $table->integer('crias_totales')->nullable();

            $table->integer('crias_vivas')->nullable();

            $table->integer('crias_muertas')->nullable();

            // Estado del proceso
            $table->enum('estado', [
                'En_Celo',
                'Servida',
                'Gestante',
                'Parida',
                'Fallida'
            ])->default('En_Celo');

            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reproduccion');
    }
};