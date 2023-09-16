<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EspecialidadsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crea un usuario de ejemplo
        DB::table('especialidads')->insert([
            'descripcion'=>'Cirujia',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('especialidads')->insert([
            'descripcion'=>'Oncologia',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('especialidads')->insert([
            'descripcion'=>'Fisioterapia',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('especialidads')->insert([
            'descripcion'=>'Rehabilitacion',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
    }
}
