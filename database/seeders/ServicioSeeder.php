<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crea un usuario de ejemplo
        DB::table('tipo_servicios')->insert([
            'nombre'=>'Cirujia',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('servicios')->insert([
            'descripcion'=>'Castracion canina',
            'precio'=> 150,
            'id_tipo_servicio'=>'1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        
    }
}
