<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('animales', function (Blueprint $table) {

            // ORIGEN (solo si no existe)
            if (!Schema::hasColumn('animales', 'origen')) {
                $table->enum('origen', ['Nacido', 'Comprado'])
                      ->after('etapa');
            }

            // FECHA INGRESO
            if (!Schema::hasColumn('animales', 'fecha_ingreso')) {
                $table->date('fecha_ingreso')
                      ->nullable()
                      ->after('origen');
            }

            // PROVEEDOR
            if (!Schema::hasColumn('animales', 'proveedor')) {
                $table->string('proveedor')
                      ->nullable()
                      ->after('fecha_ingreso');
            }

            // OBSERVACIONES
            if (!Schema::hasColumn('animales', 'observaciones')) {
                $table->text('observaciones')
                      ->nullable()
                      ->after('codigo_genetico');
            }

        });
    }

    public function down(): void
    {
        Schema::table('animales', function (Blueprint $table) {

            if (Schema::hasColumn('animales', 'origen')) {
                $table->dropColumn('origen');
            }

            if (Schema::hasColumn('animales', 'fecha_ingreso')) {
                $table->dropColumn('fecha_ingreso');
            }

            if (Schema::hasColumn('animales', 'proveedor')) {
                $table->dropColumn('proveedor');
            }

            if (Schema::hasColumn('animales', 'observaciones')) {
                $table->dropColumn('observaciones');
            }

        });
    }
};