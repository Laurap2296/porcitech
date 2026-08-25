<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('sanidad', function (Blueprint $table) {

            $table->enum('tipo_duracion', ['evento', 'tratamiento', 'control'])
                ->default('evento')
                ->after('tipo_registro');

            $table->date('fecha_inicio')
                ->nullable()
                ->after('fecha');

            $table->date('fecha_fin')
                ->nullable()
                ->after('fecha_inicio');

            $table->integer('frecuencia_dias')
                ->nullable()
                ->after('fecha_fin');
        });
    }

    public function down(): void
    {
        Schema::table('sanidad', function (Blueprint $table) {
            $table->dropColumn([
                'tipo_duracion',
                'fecha_inicio',
                'fecha_fin',
                'frecuencia_dias'
            ]);
        });
    }
};