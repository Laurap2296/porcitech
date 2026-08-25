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
        Schema::create('ventas', function (Blueprint $table) {

            $table->id();

            $table->foreignId('animal_id')
                  ->constrained('animales')
                  ->onDelete('cascade');

            $table->string('cliente');

            $table->string('documento_cliente')->nullable();

            $table->string('telefono_cliente')->nullable();

            $table->date('fecha_venta');

            $table->decimal('peso_venta', 8, 2);

            $table->decimal('precio_kilo', 12, 2);

            $table->decimal('total_venta', 12, 2);

            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};