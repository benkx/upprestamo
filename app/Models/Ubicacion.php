<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use app\Models\Prestamos;

class Ubicacion extends Model
{
    protected $table = 'ubicacion';
    protected $primaryKey = 'idubicacion';
    protected $fillable = ['codsalon', 'dotacion', 'estado'];

    use HasFactory; # trait para usar los factories


    public $timestamps = false;


//     // un Ubicacion puede tener muchos prestamos
// public function prestamos()
// {
//     return $this->hasMany(Prestamos::class, 'idubicacion');
// }

}

