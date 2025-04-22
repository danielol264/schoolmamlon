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
        Schema::create('grupo_examen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_examen');
            $table->unsignedBigInteger('id_grupo');
            $table->timestamps();
            
            $table->foreign('id_examen')->references('id')->on('examenes')->onDelete('cascade');
            $table->foreign('id_grupo')->references('id')->on('grupos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupo_examens');
    }
};
