<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produccion', function (Blueprint $table) {
            $table->dropColumn('peso');
        });
    }

    public function down(): void
    {
        Schema::table('produccion', function (Blueprint $table) {
            $table->decimal('peso', 8, 2);
        });
    }
};