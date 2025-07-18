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
        Schema::create('solimantenimiento', function (Blueprint $table) {
             
            $table->id('idsolicitud'); // Esto creará un campo 'idsolicitud' como BIGINT, autoincremental y clave primaria.
            $table->date('fechasolicitud')->comment('Fecha en que se realiza la solicitud de mantenimiento');

            // idequipo bigint (puede ser nulo, ya que no tiene NOT NULL en tu esquema original)
            // Se debe asegurar que la tabla 'equipos' exista antes de esta migración.
            $table->bigInteger('idequipo')->nullable()->comment('ID del equipo asociado a la solicitud de mantenimiento');
            $table->string('descripcion', 50)->comment('Descripción del problema o tipo de mantenimiento solicitado');
            $table->date('fechacierre')->comment('Fecha en que se cierra o completa el mantenimiento');
            // Se debe asegurar que la tabla 'usuarios' exista antes de esta migración.
            $table->bigInteger('idusuario')->nullable()->comment('ID del usuario que realiza la solicitud');
            $table->enum('estado', ['Activo', 'Cerrado'])->default('Activo')->comment('Estado actual de la solicitud de mantenimiento');
            $table->timestamps();

            // Definición de Claves Foráneas
            // FOREIGN KEY (idequipo) REFERENCES equipos(idequipo)
            // onDelete('set null') para permitir borrar un equipo sin borrar la solicitud
            // o onDelete('cascade') para borrar la solicitud si se borra el equipo.
            // He optado por 'set null' ya que idequipo es nullable en tu esquema original.
            $table->foreign('idequipo')
                  ->references('idequipo')
                  ->on('equipos')
                  ->onDelete('set null'); // O considera 'cascade' si la solicitud debe borrarse con el equipo

            // FOREIGN KEY (idusuario) REFERENCES usuarios(idusuario)
            // onDelete('set null') para permitir borrar un usuario sin borrar la solicitud
            // o onDelete('cascade') para borrar la solicitud si se borra el usuario.
            // He optado por 'set null' ya que idusuario es nullable en tu esquema original.
            $table->foreign('idusuario')
                  ->references('idusuario') // Asegúrate de que esta sea la clave primaria en tu tabla 'usuarios'
                  ->on('usuarios')
                  ->onDelete('set null'); // O considera 'cascade' si la solicitud debe borrarse con el usuario
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solimantenimiento');
    }
};
