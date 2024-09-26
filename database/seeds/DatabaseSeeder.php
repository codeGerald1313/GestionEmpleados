<?php

use Database\Seeders\ContratoSeeder;
use Database\Seeders\DatosLaboralesSeeder;
use Database\Seeders\EmpleadoSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Registra aquí tus seeders personalizados
        $this->call([
            EmpleadoSeeder::class,
            DatosLaboralesSeeder::class,
            ContratoSeeder::class,
        ]);
    }
}
