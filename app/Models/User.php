<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\DB;


class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasFactory, Notifiable, HasRoles; 
    protected $guard = 'web';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];
    public static function obtenerUsuarioRol()
{
    $results = DB::table('users')
        ->select('users.id','users.name','users.email', 'users.profile_photo_path as imagen_path', 'roles.name as rol_name', 'roles.id AS id_rol','model_has_roles.model_id as id_user_role')
        ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
        ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
        ->orderBy('users.id') 
        ->get();
    return $results;
}
public static function obtenerUsuarioRolId($id)
{
    $results = DB::table('users')
        ->select('users.id','users.name','users.email',  'users.profile_photo_path as imagen_path', 'roles.name as rol_name','roles.id AS id_rol', 'model_has_roles.model_id as id_user_role')
        ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
        ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
        ->orderBy('users.id') 
        ->where('users.id','=', $id)
        ->first();
    return $results;
}

public static function buscarLike($texto)
{
    $results = DB::table('users')
        ->select('users.id','users.name','users.email',  'users.profile_photo_path as imagen_path', 'roles.id AS id_rol','roles.name as rol_name', 'model_has_roles.model_id as id_user_role')
        ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
        ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
        ->orderBy('users.id') 
        ->where('users.name','LIKE', "%$texto%")
        ->orwhere('roles.name','LIKE', "%$texto%")
        ->orwhere('users.id','LIKE', "%$texto%")
        ->orwhere('users.email','LIKE', "%$texto%")
        ->get();
    return $results;
}
}
