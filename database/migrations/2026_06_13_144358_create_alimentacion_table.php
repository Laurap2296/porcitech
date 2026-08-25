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
        Schema::create('alimentacion', function (Blueprint $table) {

            $table->id();

            $table->foreignId('animal_id')
                  ->constrained('animales')
                  ->onDelete('cascade');

            $table->string('tipo_alimento');

            $table->decimal('cantidad_suministrada', 8, 2);

            $table->date('fecha');

            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alimentacion');
    }
};