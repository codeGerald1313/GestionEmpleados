<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmpleadoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nombres' => $this->nombres,
            'apellidos' => $this->apellidos,
            'dni' => $this->dni,
            'email' => $this->email,
            'baja' => $this->baja,
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'datos_laborales' => $this->datosLaborales ? [
                'area' => $this->datosLaborales->area,
                'cargo' => $this->datosLaborales->cargo,
                'local' => $this->datosLaborales->local,
            ] : null,
            'contratos' => $this->contratos->map(function ($contrato) {
                return [
                    'tipo_contrato' => $contrato->tipo_contrato,
                    'fecha_inicio' => $contrato->fecha_inicio,
                    'fecha_fin' => $contrato->fecha_fin ? $contrato->fecha_fin : 'Indefinido'
                ];
            }),
        ];
    }
}
