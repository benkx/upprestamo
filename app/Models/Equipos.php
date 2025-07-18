<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipos extends Model
{
    protected $table = 'equipos';
    protected $primaryKey = 'idequipo';
    protected $fillable = ['descripcion', 'codequipo', 'numserial', 'tipoequipo', 'estado'];

    public $timestamps = false; // Desactivar timestamps automáticos

    
    public function solicitudes()
    {
        return $this->hasMany(Solimantenimiento::class, 'idequipo');
    }
    // un equipo puede tener muchos prestamos
    public function prestamos()
    {
        return $this->hasMany(Prestamos::class, 'idequipo');
    }
}
