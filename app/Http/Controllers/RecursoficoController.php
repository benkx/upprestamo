<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RecursoficoController extends Controller
{

    public function index()
    {
       $recursos = [];
        $errorConexion = null;

        try {
            // *** CRÍTICO: Usar la conexión nombrada 'oracle' ***
            $oracleDB = DB::connection('oracle');

            // La consulta simple funciona porque definimos 'schema' => 'ACADEMICO' 
            // en config/database.php para esta conexión.
            $sql = "SELECT * FROM academico.v_recursofisico"; 
            
            // Ejecutamos la consulta
            $recursos = $oracleDB->select($sql);

        } catch (\Exception $e) {
            // Si la conexión falla (TNS, credenciales, Instant Client, etc.)
            $errorConexion = "Error de Conexión: " . $e->getMessage();
            
            // Opcional: Registrar el error en el log de Laravel
            \Log::error("Error al conectar o consultar Oracle: " . $e->getMessage());
        }

        // Retorna la vista, pasando los recursos o el error de conexión
        return view('recursofico.index', [
            'recursos' => $recursos,
            'error' => $errorConexion,
        ]);
    }
}