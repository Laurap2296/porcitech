<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('animales', function (Blueprint $table) {

            $table->decimal('cantidad_ajustada', 5, 2)
                ->nullable()
                ->after('peso_actual');

            $table->text('observacion_alimentacion')
                ->nullable()
                ->after('cantidad_ajustada');

        });
    }

    public function down(): void
    {
        Schema::table('animales', function (Blueprint $table) {

            $table->dropColumn([
                'cantidad_ajustada',
                'observacion_alimentacion'
            ]);

        });
    }
};