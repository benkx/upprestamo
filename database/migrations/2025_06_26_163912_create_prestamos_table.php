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
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id('idprestamo'); // Esto creará un campo 'idprestamo' como BIGINT, autoincremental y clave primaria.

            // iddocente bigint
            // Se debe asegurar que la tabla 'docentes' exista antes de esta migración.
            // Es nullable ya que no tiene NOT NULL en tu esquema original.
            $table->bigInteger('iddocente')->comment('ID del docente asociado al préstamo');

            // idubicacion bigint
            // Se debe asegurar que la tabla 'ubicacion' exista antes de esta migración.
            // Es nullable ya que no tiene NOT NULL en tu esquema original.
            $table->bigInteger('idubicacion')->comment('ID de la ubicación asociada al préstamo');

            // fechaprestamo date not null
            $table->date('fechaprestamo')->comment('Fecha en que se realiza el préstamo');
            $table->date('fechadevolucion')->comment('Fecha en que se devuelve el prestamo');
            // idusuario bigint
            // Se debe asegurar que la tabla 'usuarios' exista antes de esta migración.
            // Es nullable ya que no tiene NOT NULL en tu esquema original.
            $table->bigInteger('idusuario')->comment('ID del usuario que registra el préstamo');

            // idperoacademico bigint
            // Se debe asegurar que la tabla 'periodoacademico' exista antes de esta migración.
            // Es nullable ya que no tiene NOT NULL en tu esquema original.
            $table->bigInteger('idperoacademico')->comment('ID del periodo académico asociado al préstamo');

            // estado estado_prestamo
            // Para un tipo de dato 'estado_prestamo', se usa un ENUM en Laravel.
            // Los valores de ejemplo son 'activo', 'finalizado', 'vencido', 'cancelado'.
            // Ajusta estos valores a los estados reales que manejes para los préstamos.
            $table->enum('estado', ['Prestamo total', 'Prestamo parcial','Vencido','Finalizado'])->default('Prestamo total')->comment('Estado actual del préstamo');
            //$table->enum('estado', ['activo', 'finalizado', 'vencido', 'cancelado'])->default('activo')->comment('Estado actual del préstamo');

            $table->timestamps();

            // Definición de Claves Foráneas
            // FOREIGN KEY (iddocente) REFERENCES docentes(iddocente)
            // Usamos onDelete('set null') porque el campo es nullable y para no borrar el préstamo si se elimina el docente.
            $table->foreign('iddocente')
                  ->references('iddocente')
                  ->on('docentes')
                  ->onDelete('set null'); // O considera 'cascade' si el préstamo debe borrarse con el docente

            // FOREIGN KEY (idubicacion) REFERENCES ubicacion(idubicacion)
            // Usamos onDelete('set null') porque el campo es nullable y para no borrar el préstamo si se elimina la ubicación.
            $table->foreign('idubicacion')
                  ->references('idubicacion')
                  ->on('ubicacion')
                  ->onDelete('set null'); // O considera 'cascade' si el préstamo debe borrarse con la ubicación

            // FOREIGN KEY (idusuario) REFERENCES usuarios(idusuario)
            // Usamos onDelete('set null') porque el campo es nullable y para no borrar el préstamo si se elimina el usuario.
            $table->foreign('idusuario')
                  ->references('idusuario') // Asegúrate de que esta sea la clave primaria en tu tabla 'usuarios'
                  ->on('usuarios')
                  ->onDelete('set null'); // O considera 'cascade' si el préstamo debe borrarse con el usuario

            // FOREIGN KEY (idperoacademico) REFERENCES periodoacademico(idperoacademico)
            // Usamos onDelete('set null') porque el campo es nullable y para no borrar el préstamo si se elimina el periodo académico.
            $table->foreign('idperoacademico')
                  ->references('idperoacademico')
                  ->on('periodoacademico')
                  ->onDelete('set null'); // O considera 'cascade' si el préstamo debe borrarse con el periodo académico
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};
