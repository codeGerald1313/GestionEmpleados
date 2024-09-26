<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contrato;

class ContratoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contratos = [
            [
                'empleado_id' => 1,
                'tipo_contrato' => 'Indefinido',
                'fecha_inicio' => '2020-01-01',
                'fecha_fin' => null, // Contrato indefinido
            ],
            [
                'empleado_id' => 2,
                'tipo_contrato' => 'Temporal',
                'fecha_inicio' => '2022-06-01',
                'fecha_fin' => '2023-06-01',
            ],
            [
                'empleado_id' => 3,
                'tipo_contrato' => 'Prácticas',
                'fecha_inicio' => '2023-01-01',
                'fecha_fin' => '2023-12-31',
            ],
            [
                'empleado_id' => 4,
                'tipo_contrato' => 'Indefinido',
                'fecha_inicio' => '2019-09-15',
                'fecha_fin' => null,
            ],
            [
                'empleado_id' => 5,
                'tipo_contrato' => 'Proyecto',
                'fecha_inicio' => '2021-05-10',
                'fecha_fin' => '2022-05-10',
            ],
            [
                'empleado_id' => 6,
                'tipo_contrato' => 'Temporal',
                'fecha_inicio' => '2022-11-20',
                'fecha_fin' => '2023-11-20',
            ],
            [
                'empleado_id' => 7,
                'tipo_contrato' => 'Indefinido',
                'fecha_inicio' => '2021-07-01',
                'fecha_fin' => null,
            ],
            [
                'empleado_id' => 8,
                'tipo_contrato' => 'Temporal',
                'fecha_inicio' => '2023-02-01',
                'fecha_fin' => '2024-02-01',
            ],
            [
                'empleado_id' => 9,
                'tipo_contrato' => 'Indefinido',
                'fecha_inicio' => '2020-04-15',
                'fecha_fin' => null,
            ],
            [
                'empleado_id' => 10,
                'tipo_contrato' => 'Proyecto',
                'fecha_inicio' => '2023-03-10',
                'fecha_fin' => '2023-12-31',
            ],
        ];

        foreach ($contratos as $contrato) {
            Contrato::create($contrato);
        }
    }
}
