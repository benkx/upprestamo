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
        Schema::create('docentes', function (Blueprint $table) {
            $table->id('iddocente'); // Esto creará un campo 'iddocente' como BIGINT, autoincremental y clave primaria.
            $table->bigInteger('numdocumento')->comment('Número de documento de identidad del docente');
            $table->string('nomcompleto', 50)->comment('Nombre completo del docente');
            // vinculacion BOOLEAN
            // Un valor booleano (true/false)
            $table->boolean('vinculacion')->comment('Estado de vinculación del docente (true: vinculado, false: no vinculado)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docentes');
    }
};
