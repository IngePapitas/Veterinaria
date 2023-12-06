<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vacuna;

class VacunasSeeder extends Seeder
{
    public function run()
    {
        Vacuna::create([
            'nombre' => 'Trivalente Felina',
            'intervalo' => 0, 
            'id_especie' => 2, 
        ]);

        Vacuna::create([
            'nombre' => 'Trivalente 2da Dosis',
            'intervalo' => 28,
            'id_especie' => 2,
        ]);

        Vacuna::create([
            'nombre' => 'Trivalente 3ra Dosis',
            'intervalo' => 56,
            'id_especie' => 2,
        ]);

        Vacuna::create([
            'nombre' => 'Leucemia Felina',
            'intervalo' => 56,
            'id_especie' => 2,
        ]);

        Vacuna::create([
            'nombre' => 'Leucemia Felina 2da Dosis',
            'intervalo' => 77,
            'id_especie' => 2,
        ]);

        Vacuna::create([
            'nombre' => 'Rabia',
            'intervalo' => 28,
            'id_especie' => 2,
        ]);

        Vacuna::create([
            'nombre' => 'Moquillo',
            'intervalo' => 0,
            'id_especie' => 1,
        ]);

        Vacuna::create([
            'nombre' => 'Parvovirosis/Leptospirosis',
            'intervalo' => 0,
            'id_especie' => 1,
        ]);

        Vacuna::create([
            'nombre' => 'Hepatitis/Tos de las perreras',
            'intervalo' => 14,
            'id_especie' => 1,
        ]);

        Vacuna::create([
            'nombre' => 'Rabia',
            'intervalo' => 70,
            'id_especie' => 1,
        ]);

        Vacuna::create([
            'nombre' => 'Leishmaniasis',
            'intervalo' => 112,
            'id_especie' => 1,
        ]);
        
    }
}
