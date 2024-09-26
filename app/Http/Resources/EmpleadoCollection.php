<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EmpleadoCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // Retornar la colección de empleados 
        return $this->collection->map(function ($empleado) {
            return [
                'id' => $empleado->id,
                'nombres' => $empleado->nombres,
                'apellidos' => $empleado->apellidos,
                'dni' => $empleado->dni,
                'email' => $empleado->email,
                'baja' => $empleado->baja,
                'datos_laborales' => $empleado->datosLaborales ? [
                    'area' => $empleado->datosLaborales->area,
                    'cargo' => $empleado->datosLaborales->cargo,
                    'local' => $empleado->datosLaborales->local,
                ] : null,
                'contratos' => $empleado->contratos->map(function ($contrato) {
                    return [
                        'tipo_contrato' => $contrato->tipo_contrato,
                        'fecha_inicio' => $contrato->fecha_inicio,
                        'fecha_fin' => $contrato->fecha_fin ? $contrato->fecha_fin : 'Indefinido',
                    ];
                }),
                'created_at' => $empleado->created_at ? $empleado->created_at->format('Y-m-d H:i:s') : null,
                'updated_at' => $empleado->updated_at ? $empleado->updated_at->format('Y-m-d H:i:s') : null,
            ];
        })->toArray();
    }
}
