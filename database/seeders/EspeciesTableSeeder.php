<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EspeciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crea un usuario de ejemplo
        DB::table('especies')->insert([
            'nombre'=>'Can',
            'imagen_path'=>'AvataresPacientes/can.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('especies')->insert([
            'nombre'=>'Felino',
            'imagen_path'=>'AvataresPacientes/felino.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
