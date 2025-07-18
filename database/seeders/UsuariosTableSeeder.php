<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Usuarios; // Asegúrate de importar tu modelo
use Illuminate\Support\Facades\Hash; // Para hashear la contraseña

class UsuariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Usuarios::create([
            'idusuario' => '5',
            'nomusuario' => 'test11',
            'contrasena' => Hash::make('up123123'), // ¡¡¡IMPORTANTE: HASHEAR LA CONTRASEÑA!!!
            'nomcompleto' => 'Usuario de Prueba',
            'estado' => 'Activo', // Puedes usar 'Inactivo' si lo prefieres
            // 'remember_token' => null, // Esto es opcional, Laravel lo gestionará
            // 'created_at' => now(), // $table->timestamps() en la migración se encarga
            // 'updated_at' => now(), // $table->timestamps() en la migración se encarga
        ]);

        // Puedes añadir más usuarios aquí
        Usuarios::create([
            'nomusuario' => 'admin',
            'contrasena' => Hash::make('password'),
            'nomcompleto' => 'Administrador',
            'estado' => 'Activo',
        ]);
    }
}