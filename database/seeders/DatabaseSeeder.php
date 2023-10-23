<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UsersTableSeeder;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesPermisosSeeder::class);
        //$this->call(UsersTableSeeder::class);
        $this->call(EspecialidadsTableSeeder::class);
        $this->call(EspeciesTableSeeder::class);
        $this->call(RazasTableSeeder::class);
        $this->cargarUsuarios();
    }

    public function cargarUsuarios(){
        $u = new User();
        $u->id = 100;
        $u->name = 'Elio Andres Osinaga Vargas';
        $u->email = 'osinagax10@gmail.com';
        $u->password = bcrypt('12345678e');
        $u->assignRole(['Admin']);
        $u->save();
    }
}
