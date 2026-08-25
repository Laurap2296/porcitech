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
        Schema::table('produccion', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | NUEVO TIPO DE REGISTRO
            |--------------------------------------------------------------------------
            |
            | Actualmente existen:
            | mensual
            | sacrificio
            |
            | Se agrega:
            | muerto
            |
            */

            $table->string('tipo_registro')
                ->default('mensual')
                ->change();

            /*
            |--------------------------------------------------------------------------
            | RESULTADO
            |--------------------------------------------------------------------------
            |
            | Mensual:
            | ganancia de peso.
            |
            | Sacrificio:
            | rendimiento de canal.
            |
            */

            if (!Schema::hasColumn('produccion', 'resultado')) {
                $table->decimal('resultado', 8, 2)
                    ->nullable()
                    ->after('peso_canal');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produccion', function (Blueprint $table) {

            if (Schema::hasColumn('produccion', 'resultado')) {
                $table->dropColumn('resultado');
            }

        });
    }
};