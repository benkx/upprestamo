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
        Schema::create('detalleprestamo', function (Blueprint $table) {
        
            $table->id('iddetprestamo'); // Esto creará un campo 'iddetprestamo' como BIGINT, autoincremental y clave primaria.

            // idprestamo bigint (nullable)
            // Se debe asegurar que la tabla 'prestamos' exista antes de esta migración.
            // Es nullable ya que no tiene NOT NULL en tu esquema original.
            $table->bigInteger('idprestamo')->comment('ID del préstamo al que pertenece este detalle');
            $table->bigInteger('idequipo')->comment('ID del equipo específico prestado en este detalle');
            $table->date('fechaentrega')->comment('Fecha en que el equipo fue entregado para el préstamo');
            $table->date('fechadevolucion')->comment('Fecha en que el equipo fue devuelto del préstamo');
            $table->string('observacionentrega', 100)->comment('Observaciones al momento de la entrega del equipo');
            $table->string('observaciondevolucion', 100)->nullable()->comment('Observaciones al momento de la devolución del equipo');

            // estado_detalle
            // Para un tipo de dato 'estado_detalle', se usa un ENUM en Laravel.
            // Los valores de ejemplo son 'entregado', 'devuelto', 'pendiente_devolucion', 'danado'.
            // Ajusta estos valores a los estados reales que manejes para los detalles de préstamo.
            $table->enum('estado_detalle', ['Entregado', 'Devuelto'])->default('Entregado')->comment('Estado del equipo en este detalle de préstamo');

            // Opcional: Si necesitas timestamps (created_at y updated_at)
            $table->timestamps();

            // Definición de Claves Foráneas
            // FOREIGN KEY (idprestamo) REFERENCES prestamos(idprestamo)
            // Usamos onDelete('set null') para mantener consistencia con otros campos nullable.
            $table->foreign('idprestamo')
                  ->references('idprestamo')
                  ->on('prestamos')
                  ->onDelete('set null'); // O 'cascade' si el detalle debe borrarse con el préstamo

            // FOREIGN KEY (idequipo) REFERENCES equipos(idequipo)
            // Usamos onDelete('set null') para mantener consistencia con otros campos nullable.
            $table->foreign('idequipo')
                  ->references('idequipo')
                  ->on('equipos')
                  ->onDelete('set null'); // O 'cascade' si el detalle debe borrarse con el equipo
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalleprestamo');
    }
};
