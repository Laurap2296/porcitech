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
        Schema::table('reproduccion', function (Blueprint $table) {

            $table->date('fecha_revision_celo')
                  ->nullable()
                  ->after('fecha_servicio');

            $table->enum('repitio_celo', ['Si', 'No'])
                  ->nullable()
                  ->after('fecha_revision_celo');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reproduccion', function (Blueprint $table) {

            $table->dropColumn([
                'fecha_revision_celo',
                'repitio_celo'
            ]);

        });
    }
};