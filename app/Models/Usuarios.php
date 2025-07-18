<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
#use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable; 
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;

class Usuarios extends Model implements Authenticatable
{
    use HasFactory, AuthenticatableTrait;
    protected $table = 'usuarios'; // Nombre de la tabla
    protected $primaryKey = 'idusuario'; // Clave primaria 
    public $timestamps = false; // Desactivar timestamps automáticos

    protected $fillable = [
        'nomusuario',
        'contrasena',
        'nomcompleto',
        'estado',
    ];

    protected $hidden = [
        'constrasena',
    ];

    // Métodos para autenticación
    public function getAuthIdentifierName() { return 'nomusuario'; }
    public function getAuthIdentifier() {   return $this->{$this->getAuthIdentifierName()}; }

    public function setPasswordAttribute($input)
    {
        if($input){
            $this->attributes['contrasena']== app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
        //$this->attributes['contrasena'] = Hash::make($contrasena);
    }
    public function getAuthPassword() { return $this->contrasena; }


    // Definir relaciones, si es necesario

    // public function solicitudes()
    // {
    //     return $this->hasMany(Solimantenimiento::class, 'idusuario');
    // }

    // public function setRememberToken($value)
    // {
    //     $this->remember_token = $value;
    // }

    /**
     * Obtener el "remember me" token.
     *
     * @return string
     */
    // public function getRememberToken()
    // {
    //     return $this->remember_token;
    // }
}
