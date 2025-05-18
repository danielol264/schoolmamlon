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
        Schema::table('examenes', function (Blueprint $table) {
            $table->integer('cantidadPreguntas')->after('id_maestro');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('examenes', function (Blueprint $table) {
            $table->dropColumn('cantidadPreguntas');
        });
    }
};
