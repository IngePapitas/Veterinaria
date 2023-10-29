<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EstadoPacientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crea un usuario de ejemplo
        DB::table('estado_pacientes')->insert([
            'descripcion'=>'Excelente',
            
        ]);
        DB::table('estado_pacientes')->insert([
            'descripcion'=>'Bueno',
            
        ]);
        DB::table('estado_pacientes')->insert([
            'descripcion'=>'Estable',
            
        ]);
        DB::table('estado_pacientes')->insert([
            'descripcion'=>'Malo',
            
        ]);
        DB::table('estado_pacientes')->insert([
            'descripcion'=>'Critico',
            
        ]);
        
    }
}
