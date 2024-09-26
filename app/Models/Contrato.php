<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contrato extends Model
{
    use SoftDeletes;

    protected $fillable = ['empleado_id', 'fecha_inicio', 'fecha_fin', 'tipo_contrato'];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }
}
