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
        Schema::create('usuarios', function (Blueprint $table) {
            // Clave primaria: idusuario (bigserial en PostgreSQL, bigIncrements en Laravel)
            $table->bigIncrements('idusuario');

            // Nombre de usuario: nomusuario (varchar(50) not null)
            $table->string('nomusuario', 50)->unique(); // unique para asegurar nombres de usuario únicos

            // Contraseña: contrasena (varchar(250) not null)
            // Se usa string porque almacenará el hash de bcrypt, que es largo.
            $table->string('contrasena', 250);

            // Nombre completo: nomcompleto (varchar(50) not null)
            $table->string('nomcompleto', 50);

            // Estado del usuario: estado (tipo 'estado_usuario' en PostgreSQL)
            // Como 'estado_usuario' es un tipo ENUM personalizado de PostgreSQL,
            // lo representamos como un string en la migración de Laravel.
            // La validación de los valores permitidos ('ACTIVO', 'INACTIVO', etc.)
            // se debe hacer en el modelo o en las reglas de validación de los controladores.
            $table->string('estado'); // Opcional: ->default('ACTIVO') si tienes un valor por defecto

            // NO se usan $table->timestamps(); porque tu esquema no las tiene.
            // NO se usa $table->rememberToken(); porque tu esquema no lo tiene.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
