<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEmpleadoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        // Capturar el ID si está presente
        $empleadoId = $this->route('id') ?? $this->route('empleado');

        return [
            'nombres' => 'required|string|max:255|regex:/^[\pL\s]+$/u', // Asegura solo letras y espacios
            'apellidos' => 'required|string|max:255|regex:/^[\pL\s]+$/u', // Asegura solo letras y espacios
            'dni' => [
                'required',
                'string',
                'size:8',
                Rule::unique('empleados')->ignore($empleadoId),
                'regex:/^[0-9]+$/', // Asegura que el DNI solo contenga números
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('empleados')->ignore($empleadoId),

            ],
            'fecha_nacimiento' => 'required|date|before:today', // La fecha debe ser antes de hoy
            'area' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'local' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio', // La fecha fin debe ser después o igual a fecha inicio
            'tipo_contrato' => [
                'required',
                'string',
                'max:255',
                Rule::in(['Indefinido', 'Temporal', 'Prácticas', 'Por Proyecto', 'Freelancer']), // Valores aceptados para tipo de contrato
            ],
        ];
    }

    public function messages()
    {
        return [
            'nombres.required' => 'El campo Nombres es obligatorio.',
            'nombres.regex' => 'El campo Nombres solo puede contener letras y espacios.',
            'apellidos.required' => 'El campo Apellidos es obligatorio.',
            'apellidos.regex' => 'El campo Apellidos solo puede contener letras y espacios.',
            'dni.required' => 'El campo DNI es obligatorio.',
            'dni.size' => 'El DNI debe tener exactamente 8 caracteres.',
            'dni.unique' => 'El DNI ingresado ya existe en el sistema.',
            'dni.regex' => 'El DNI solo puede contener números.',
            'email.required' => 'El campo Email es obligatorio.',
            'email.email' => 'El Email ingresado no tiene un formato válido.',
            'email.unique' => 'El Email ingresado ya existe en el sistema.',
            'fecha_nacimiento.required' => 'El campo Fecha de Nacimiento es obligatorio.',
            'fecha_nacimiento.before' => 'La Fecha de Nacimiento debe ser una fecha anterior a hoy.',
            'area.required' => 'El campo Área es obligatorio.',
            'cargo.required' => 'El campo Cargo es obligatorio.',
            'local.required' => 'El campo Local es obligatorio.',
            'fecha_inicio.required' => 'El campo Fecha de Inicio es obligatorio.',
            'fecha_fin.after_or_equal' => 'La Fecha de Fin debe ser igual o posterior a la Fecha de Inicio.',
            'tipo_contrato.required' => 'El campo Tipo de Contrato es obligatorio.',
            'tipo_contrato.in' => 'El Tipo de Contrato debe ser uno de los siguientes valores: indefinido, temporal, prácticas.',
        ];
    }
}
