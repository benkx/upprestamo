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
        Schema::create('periodoacademico', function (Blueprint $table) {

            $table->id('idperoacademico'); // Esto creará un campo 'idperoacademico' como BIGINT, autoincremental y clave primaria.
            $table->string('descripcion', 20)->comment('Descripción o nombre del periodo académico (ej. "2024-1", "2023-II")');
            $table->enum('estado', ['Activo', 'Cerrado'])->default('Activo')->comment('Estado actual del periodo académico');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periodo_academico');
    }
};
