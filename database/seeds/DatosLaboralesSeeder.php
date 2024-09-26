<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DatosLaborales;

class DatosLaboralesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datosLaborales = [
            [
                'empleado_id' => 1,
                'area' => 'Ventas',
                'cargo' => 'Gerente',
                'local' => 'Lima',
            ],
            [
                'empleado_id' => 2,
                'area' => 'Recursos Humanos',
                'cargo' => 'Asistente',
                'local' => 'Arequipa',
            ],
            [
                'empleado_id' => 3,
                'area' => 'IT',
                'cargo' => 'Desarrollador',
                'local' => 'Cusco',
            ],
            [
                'empleado_id' => 4,
                'area' => 'Marketing',
                'cargo' => 'Coordinador',
                'local' => 'Lima',
            ],
            [
                'empleado_id' => 5,
                'area' => 'Finanzas',
                'cargo' => 'Analista',
                'local' => 'Lima',
            ],
            [
                'empleado_id' => 6,
                'area' => 'Logística',
                'cargo' => 'Supervisor',
                'local' => 'Ica',
            ],
            [
                'empleado_id' => 7,
                'area' => 'Ventas',
                'cargo' => 'Ejecutivo',
                'local' => 'Lima',
            ],
            [
                'empleado_id' => 8,
                'area' => 'IT',
                'cargo' => 'Administrador de Sistemas',
                'local' => 'Piura',
            ],
            [
                'empleado_id' => 9,
                'area' => 'Recursos Humanos',
                'cargo' => 'Jefe de Personal',
                'local' => 'Lima',
            ],
            [
                'empleado_id' => 10,
                'area' => 'Ventas',
                'cargo' => 'Asesor Comercial',
                'local' => 'Trujillo',
            ],
        ];

        foreach ($datosLaborales as $datoLaboral) {
            DatosLaborales::create($datoLaboral);
        }
    }
}
