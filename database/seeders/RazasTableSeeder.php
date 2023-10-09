<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RazasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crea un usuario de ejemplo
        DB::table('razas')->insert([
            'nombre'=>'Criollo',
            'id_especie'=>'1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('razas')->insert([
            'nombre'=>'Criollo',
            'id_especie'=>'2',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
