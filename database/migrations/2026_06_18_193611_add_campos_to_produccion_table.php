<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produccion', function (Blueprint $table) {
            $table->string('tipo_registro')->default('mensual');
            $table->decimal('peso_vivo', 8, 2)->nullable();
            $table->decimal('peso_canal', 8, 2)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('produccion', function (Blueprint $table) {
            $table->dropColumn(['tipo_registro', 'peso_vivo', 'peso_canal']);
        });
    }
};