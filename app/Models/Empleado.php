<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empleado extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombres',
        'apellidos',
        'dni',
        'email',
        'fecha_nacimiento',
        'baja', 
    ];
    public function datosLaborales()
    {
        return $this->hasOne(DatosLaborales::class);
    }

    public function contratos()
    {
        return $this->hasMany(Contrato::class);
    }
}
