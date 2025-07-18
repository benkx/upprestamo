<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solimantenimiento extends Model
{
    protected $table = 'solimantenimiento';
    protected $primaryKey = 'idsolicitud';
    protected $fillable = ['fechasolicitud', 'idequipo', 'descripcion', 'fechacierre', 'idusuario', 'estado'];

    public $timestamps = false; // Desactivar timestamps automáticos

    // un equipo puede tener muchos prestamos
    public function equipos()
    {
        return $this->belongsTo(Equipos::class, 'idequipo');
    }

    // un usuario puede tener muchos prestamos
    public function usuarios()
    {
        return $this->belongsTo(Usuarios::class, 'idusuario');
    }


    // // un periodo academico puede tener muchos prestamos
    // public function periodoacademico()
    // {
    //     return $this->belongsTo(Periodoacademico::class, 'idperiodoacademico');
    // }
}
