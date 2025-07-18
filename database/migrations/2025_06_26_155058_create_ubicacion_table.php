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
        Schema::create('ubicacion', function (Blueprint $table) {
           
            $table->id('idubicacion'); // Esto creará un campo 'idubicacion' como BIGINT, autoincremental y clave primaria.
            $table->string('codsalon', 50)->unique()->comment('Código o nombre del salón, debe ser único'); // Añadido unique para codsalon
            $table->string('dotacion', 100)->comment('Descripción de la dotación del salón');
            $table->enum('estado', ['Disponible', 'No Disponible'])->default('Disponible')->comment('Estado actual del salón');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ubicacion');
    }
};
