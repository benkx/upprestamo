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
        Schema::table('prestamos', function (Blueprint $table) {
            DB::statement("ALTER TABLE prestamos DROP CONSTRAINT IF EXISTS prestamos_estado_check;");
           # DB::statement("ALTER TABLE prestamos ADD CONSTRAINT prestamos_estado_check CHECK (estado IN ('Activo', 'Finalizado', 'Vencido', 'Cancelado', 'Prestado total', 'Prestado Parcial'));");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prestamos', function (Blueprint $table) {
             DB::statement("ALTER TABLE prestamos ADD CONSTRAINT prestamos_estado_check CHECK (estado IN ('Activo', 'Finalizado', 'Vencido', 'Cancelado', 'Prestado total', 'Prestado Parcial'));");
        });
    }
};
