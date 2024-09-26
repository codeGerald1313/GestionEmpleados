<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DatosLaborales extends Model
{
    use SoftDeletes;

    protected $fillable = ['empleado_id', 'area', 'cargo', 'local'];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }
}
