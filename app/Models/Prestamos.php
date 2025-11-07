<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;
use App\Models\Docentes;
use App\Models\Ubicacion;
use App\Models\Periodoacademico;
use App\Models\Usuarios;
use App\Models\DetallePrestamo;

class Prestamos extends Model
{
 
    protected $table = 'prestamos';

    protected $primaryKey = 'idprestamo';
    protected $fillable = ['idubicacion', 'fechaprestamo', 'idperoacademico', 'estado','nomfuncionarios','iddocente'];


    public $timestamps = true; 


     protected $casts = [
        'fechaprestamo' => 'date',
    ];

    public const ESTADO_ACTIVO = 'Activo';
    public const ESTADO_FINALIZADO = 'Finalizado';
    public const ESTADO_VENCIDO = 'Vencido';
    public const ESTADO_CANCELADO = 'Cancelado';

    public static function getEstadosValidos()
    {
        return [
            self::ESTADO_ACTIVO,
            self::ESTADO_FINALIZADO,
            self::ESTADO_VENCIDO,
            self::ESTADO_CANCELADO,
        ];
    }

    // un prestamo pertenece a un docente
    public function docente()
    {
        return $this->belongsTo(Docentes::class, 'iddocente');
    }

    // un prestamo pertenece a una ubicacion
    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class, 'idubicacion');
    }
    
    public function periodoacademico()
    {
        return $this->belongsTo(Periodoacademico::class, 'idperoacademico');
    }                                                                           

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'idusuario', 'idusuario');
    }

    public function detalleprestamos()
    {
        return $this->hasMany(Detalleprestamo::class, 'iddetprestamo'); //'idprestamo'
    }
    
    public function detalles()
    {
        return $this->hasMany(DetallePrestamo::class, 'idprestamo','idprestamo');
    }

     public function getProgresoDevolucionAttribute()
    {
        // Cargamos la relación de detalles si no ha sido cargada
        if (!$this->relationLoaded('detalles')) {
            $this->load('detalles');
        }

        $totalEquipos = $this->detalles->count();
        
        // Contamos los equipos que aún están en estado 'Entregado' (pendientes de acción)
        $entregadosPendientes = $this->detalles->where('estado_detalle', 'Entregado')->count();

        // Los equipos que ya han sido procesados (Devueltos, Dañados, Vencidos, etc.)
        $devueltosProcesados = $totalEquipos - $entregadosPendientes;

        // Si todos han sido procesados, devolvemos 'Finalizado' para mayor claridad
        if ($entregadosPendientes === 0) {
             return "(0 de {$totalEquipos})";
        }

        return "({$devueltosProcesados} de {$totalEquipos})";
    }
}
