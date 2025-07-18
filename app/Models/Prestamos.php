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
    
    protected $fillable = ['iddocente', 'idubicacion', 'fechaprestamo','fechadevolucion','idusuario', 'idperoacademico', 'estado'];

    public $timestamps = true; 
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
        return $this->belongsTo(Usuarios::class, 'idusuario');
    }

    public function detalleprestamos()
    {
        return $this->hasMany(Detalleprestamo::class, 'iddetprestamo'); //'idprestamo'
    }
    
    public function detalles()
    {
        return $this->hasMany(DetallePrestamo::class, 'idprestamo','idprestamo');
    }
}
