<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesPermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
            $Admin          = Role::create(['name' => 'Admin']);

            Permission::create(['name' => 'Ver Paciente'])->syncRoles([$Admin]);
            Permission::create(['name' => 'Registrar Paciente'])->syncRoles([$Admin]);
            Permission::create(['name' => 'Editar Paciente'])->syncRoles([$Admin]);
    
            Permission::create(['name' => 'Ver Personal'])->syncRoles([$Admin]);
            Permission::create(['name' => 'Crear Personal'])->syncRoles([$Admin]);
            Permission::create(['name' => 'Editar Personal'])->syncRoles([$Admin]);
    
            Permission::create(['name' => 'Ver Usuario'])->syncRoles([$Admin]);
            Permission::create(['name' => 'Crear Usuario'])->syncRoles([$Admin]);
            Permission::create(['name' => 'Editar Usuario'])->syncRoles([$Admin]);
            
            Permission::create(['name' => 'Ver Especie'])->syncRoles([$Admin]);
            Permission::create(['name' => 'Crear Especie'])->syncRoles([$Admin]);
            Permission::create(['name' => 'Editar Especie'])->syncRoles([$Admin]);
    
            Permission::create(['name' => 'Ver Medicamento'])->syncRoles([$Admin]);
            Permission::create(['name' => 'Crear Medicamento'])->syncRoles([$Admin]);
            Permission::create(['name' => 'Editar Medicamento'])->syncRoles([$Admin]);
       
    }
}