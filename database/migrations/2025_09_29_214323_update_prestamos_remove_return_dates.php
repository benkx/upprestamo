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
            // Asumo que estas columnas existían. Si tenían otro nombre, ajústalos aquí.
            if (Schema::hasColumn('prestamos', 'fechadevolucion')) {
                $table->dropColumn('fechadevolucion');
            }
            
   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prestamos', function (Blueprint $table) {
            $table->date('fechadevolucion')->nullable();
        });
    }
};
