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
        Schema::table('detalleprestamo', function (Blueprint $table) {
            DB::statement("ALTER TABLE detalleprestamo DROP CONSTRAINT IF EXISTS detalleprestamo_estado_detalle_check;");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detalleprestamo', function (Blueprint $table) {
            
             DB::statement("ALTER TABLE detalleprestamo ADD CONSTRAINT detalleprestamo_estado_detalle_check CHECK (estado IN ('Devuelto', 'Entregado', 'Vencido', 'Dañado'));");
        });
    }
};
