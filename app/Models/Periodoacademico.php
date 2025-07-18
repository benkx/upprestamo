<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periodoacademico extends Model
{
    protected $table = 'periodoacademico';
    protected $primaryKey = 'idperoacademico';
    protected $fillable = ['descripcion', 'estado'];

    public $timestamps = false; // Si no usas timestamps, descomentar esta línea

    // un periodo academico puede tener muchos prestamos
    // public function prestamos()
    // {
    //     return $this->hasMany(Prestamos::class, 'idperiodoacademico');
    // }

    public function solicitudes()
    {
        return $this->hasMany(Prestamos::class, 'idprestamo');
    }
}
