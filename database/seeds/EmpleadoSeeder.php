<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Empleado;

class EmpleadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $empleados = [
            [
                'nombres' => 'Juan',
                'apellidos' => 'Pérez',
                'dni' => '12345678',
                'email' => 'juan.perez@example.com',
                'fecha_nacimiento' => '1985-04-23',
            ],
            [
                'nombres' => 'María',
                'apellidos' => 'González',
                'dni' => '87654321',
                'email' => 'maria.gonzalez@example.com',
                'fecha_nacimiento' => '1990-07-15',
            ],
            [
                'nombres' => 'Carlos',
                'apellidos' => 'Ramírez',
                'dni' => '34567891',
                'email' => 'carlos.ramirez@example.com',
                'fecha_nacimiento' => '1988-02-10',
            ],
            [
                'nombres' => 'Ana',
                'apellidos' => 'López',
                'dni' => '56789012',
                'email' => 'ana.lopez@example.com',
                'fecha_nacimiento' => '1992-05-19',
            ],
            [
                'nombres' => 'Luis',
                'apellidos' => 'Martínez',
                'dni' => '67890123',
                'email' => 'luis.martinez@example.com',
                'fecha_nacimiento' => '1980-11-30',
            ],
            [
                'nombres' => 'Elena',
                'apellidos' => 'Hernández',
                'dni' => '78901234',
                'email' => 'elena.hernandez@example.com',
                'fecha_nacimiento' => '1985-08-22',
            ],
            [
                'nombres' => 'Pedro',
                'apellidos' => 'García',
                'dni' => '89012345',
                'email' => 'pedro.garcia@example.com',
                'fecha_nacimiento' => '1993-03-17',
            ],
            [
                'nombres' => 'Laura',
                'apellidos' => 'Vásquez',
                'dni' => '90123456',
                'email' => 'laura.vasquez@example.com',
                'fecha_nacimiento' => '1987-12-05',
            ],
            [
                'nombres' => 'Fernando',
                'apellidos' => 'Torres',
                'dni' => '01234567',
                'email' => 'fernando.torres@example.com',
                'fecha_nacimiento' => '1995-09-25',
            ],
            [
                'nombres' => 'Rosa',
                'apellidos' => 'Díaz',
                'dni' => '23456789',
                'email' => 'rosa.diaz@example.com',
                'fecha_nacimiento' => '1991-06-30',
            ],
        ];

        foreach ($empleados as $empleado) {
            Empleado::create($empleado);
        }
    }
}
