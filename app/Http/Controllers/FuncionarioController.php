<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class FuncionarioController extends Controller
{
    
    public function index()
    {
       $funcionarios = [];
        $errorConexion = null;

        try {
            // *** CRÍTICO: Usar la conexión nombrada 'oracle' ***
            $oracleDB = DB::connection('oracle');

            // La consulta simple funciona porque definimos 'schema' => 'ACADEMICO' 
            // en config/database.php para esta conexión.
            $sql = "SELECT * FROM academico.v_funcionarios"; 
            
            // Ejecutamos la consulta
            $funcionarios = $oracleDB->select($sql);

        } catch (\Exception $e) {
            // Si la conexión falla (TNS, credenciales, Instant Client, etc.)
            $errorConexion = "Error de Conexión: " . $e->getMessage();
            
            // Opcional: Registrar el error en el log de Laravel
            \Log::error("Error al conectar o consultar Oracle: " . $e->getMessage());
        }

        // Retorna la vista, pasando los funcionarios o el error de conexión
        return view('funcionarios.index', [
            'funcionarios' => $funcionarios,
            'error' => $errorConexion,
        ]);
    }
}