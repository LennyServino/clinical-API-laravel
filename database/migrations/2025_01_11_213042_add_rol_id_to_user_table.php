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
        Schema::table('users', function (Blueprint $table) {
            //agregando una nueva columna a la tabla users
            $table->unsignedBigInteger('rol_id')->after('id'); //agregando el campo despues del campo id
            //agregando la llave foranea
            $table->foreign('rol_id')->references('id')->on('rol');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //eliminamos la columna cuando se revierte la migracion
            $table->dropForeign(['rol_id']);
            $table->dropColumn('rol_id');
        });
    }
};
