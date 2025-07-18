<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detalleprestamo extends Model
{
    protected $table = 'detalleprestamo';
    protected $primaryKey = 'iddetprestamo';
    protected $fillable = ['idprestamo', 'idequipo', 'fechaentrega', 'fechadevolucion',
        'observacionentrega', 'observaciondevolucion', 'estado_detalle'];

    // un detalle de prestamo pertenece a un prestamo
    public function prestamos()
    {
        return $this->belongsTo(Prestamos::class, 'idprestamo');
    }

    // un detalle de prestamo pertenece a un equipo
    public function equipo()
    {
        return $this->belongsTo(Equipos::class, 'idequipo');
    }

    // un detalle de prestamo pertenece a un docente
    public function docente()
    {
        return $this->belongsTo(Docentes::class, 'iddocente');
    }

    // public function detalles()
    // {
    //     return $this->hasMany(DetallePrestamo::class, 'idprestamo','idprestamo');
    // }
}
