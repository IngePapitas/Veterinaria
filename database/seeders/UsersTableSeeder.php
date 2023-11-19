<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crea un usuario de ejemplo
        

        $u = new User();
        $u->id = 100;
        $u->name = 'Elio Andres Osinaga Vargas';
        $u->email = 'julio@correo.com';
        $u->password = bcrypt('password');
        $u->assignRole(['Admin']);
        $u->save();

        
    }
}
