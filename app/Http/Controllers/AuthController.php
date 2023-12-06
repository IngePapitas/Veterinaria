<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use App\Models\Cita;
use App\Models\producto;
use Illuminate\Support\Facades\DB;
class AuthController extends Controller
{
    //Register user
    public function register(Request $request){


        $attrs = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);


        $user = User::create([
            'name' => $attrs['name'],
            'email' => $attrs['email'],
            'password' => bcrypt($attrs['password'])
        ]);



        return response([
            'user' => $user,
            'token' => $user->createToken('secret')->plainTextToken
        ]);
    }
    //Login
    public function login(Request $request){


        $attrs = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);


        if(!Auth::attempt($attrs)){
            return response([
                'message' => 'Invalid  credenciales.'
            ],403);
        }
        $user = Auth::user();
        return response([

            'user' => $user,
            'token' => $user->createToken('secret')->plainTextToken
        ],200);
    }

    public function productos(){
        $productos = Producto::all();
        return response([
            'productos' => $productos
        ],200);
    }

    public function logout(){
        $user = Auth::user();
        $user->tokens()->delete();  
        return response([
            'message' => 'Logout success'
        ],200);
    }

    public function user(){
        return response([
            'user' => Auth::user(),

        ],200);
    }
    public function mascotas(){
        $user = Auth::user();
        $correo = $user->email;
        $id = DB::table('clientes')
        ->join('users', 'clientes.correo', '=', 'users.email')
        ->where('users.email', '=', $correo)
        ->select('clientes.id')
        ->first();

        $mascotas = DB::table('nota_servicios')
         ->select(
          'pacientes.*'
              )
             ->leftJoin('clientes', 'clientes.id', '=', 'nota_servicios.id_cliente')
             ->leftJoin('pacientes', 'pacientes.id', '=', 'nota_servicios.id_paciente')
             ->where('clientes.id', '=', $id->id) // Acceder al ID de la consulta anterior
             ->get();

            return response([
                'mascotas' => $mascotas,
    
            ],200);
    }

    public function citas(){
        $user = Auth::user();
        $correo = $user->email;
        $id = DB::table('clientes')
        ->join('users', 'clientes.correo', '=', 'users.email')
        ->where('users.email', '=', $correo)
        ->select('clientes.id')
        ->first();

        $mascotas = DB::table('nota_servicios')
         ->select(
          'pacientes.*'
              )
             ->leftJoin('clientes', 'clientes.id', '=', 'nota_servicios.id_cliente')
             ->leftJoin('pacientes', 'pacientes.id', '=', 'nota_servicios.id_paciente')
             ->where('clientes.id', '=', $id->id) // Acceder al ID de la consulta anterior
             ->get();
        
             $citas = DB::table('citas')
             ->select(
                 'citas.id as cita_id',
                 'citas.fecha',
                 'citas.hora',
                 'personals.nombre as nombre_personal',
                 'pacientes.nombre as nombre_paciente',
                 'pacientes.imagen_path as imagen_paciente'
             )
             ->join('personals', 'citas.id_personal', '=', 'personals.id')
             ->join('pacientes', 'citas.id_paciente', '=', 'pacientes.id')
             ->whereIn('citas.id_paciente', $mascotas->pluck('id'))
             ->where('citas.estado', '=', 0)
             ->get();
        
        return response([
            'citas' => $citas,

        ],200);
        
    }


}