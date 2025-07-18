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
        Schema::create('equipos', function (Blueprint $table) {
            $table->id('idequipo'); // Esto creará un campo 'idequipo' como BIGINT, autoincremental y clave primaria.
            $table->string('descripcion', 100)->comment('Descripción breve del equipo');
            // codequipo bigint not null
            // Un código de equipo podría ser único. Si es así, añade ->unique().
            $table->bigInteger('codequipo')->unique()->comment('Código identificador del equipo');
            $table->string('numserial', 50)->comment('Número de serie único del equipo');
            $table->string('tipoequipo', 50)->comment('Tipo de equipo (ej. "Portátil", "Proyector", "Tableta")');
            $table->enum('estado', ['Disponible', 'Ocupado', 'Mantenimiento', 'Inactivo'])->default('Disponible')->comment('Estado actual del equipo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};
