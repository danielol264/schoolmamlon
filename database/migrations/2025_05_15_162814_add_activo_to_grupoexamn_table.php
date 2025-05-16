<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
    {
        Schema::table('grupo_examens', function (Blueprint $table) {
            $table->integer('activo')->after('id_grupo');
        });
    }

    public function down(): void
    {
        Schema::table('grupo_examens', function (Blueprint $table) {
            $table->dropColumn('activo');
        });
    }
};
