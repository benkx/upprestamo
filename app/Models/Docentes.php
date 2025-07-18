<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Docentes extends Model
{
    protected $table = 'docentes';
    protected $primaryKey = 'iddocente';
    protected $fillable = ['numdocumento', 'nomcompleto', 'vinculcion'];

    public $timestamps = false;

    // un docente puede tener muchos prestamos
    // public function prestamos()
    // {
    //     return $this->hasMany(Prestamos::class, 'iddocente');
    // }
}
