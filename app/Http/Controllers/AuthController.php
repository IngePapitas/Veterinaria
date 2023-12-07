<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use App\Models\Cita;
use App\Models\producto;
use Illuminate\Support\Facades\DB;
use App\Models\carrito;
use App\Models\detalle_carrito;
use App\Models\valoracion;
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

    public function notasDeServicio(){
        $user = Auth::user();
        $correo = $user->email;
        $id = DB::table('clientes')
        ->join('users', 'clientes.correo', '=', 'users.email')
        ->where('users.email', '=', $correo)
        ->select('clientes.id')
        ->first();
    
        $notasDeServicio = DB::table('nota_servicios')
        ->select(
            'nota_servicios.id',
            'pacientes.nombre as nombre_paciente',
            'nota_servicios.total',
            'nota_servicios.created_at as fecha'
        )
        ->join('clientes', 'clientes.id', '=', 'nota_servicios.id_cliente')
        ->join('pacientes', 'pacientes.id', '=', 'nota_servicios.id_paciente')
        ->where('clientes.id', '=', $id->id) // Acceder al ID de la consulta anterior
        ->get();
    
        return response([
            'notasDeServicio' => $notasDeServicio,
        ],200);
    }

    public function valoracion(Request $request)
{
    $valoracion = new Valoracion();
    $valoracion->valoracion = $request->valoracion;
    $valoracion->id_nota = $request->id_nota;
    $valoracion->save();

    return response()->json(['message' => 'Valoración guardada']);
}

    


    public function carrito(){
        $id = auth()->user()->id;
        $carrito = carrito::where('cliente_id', $id)->first();
        // dd($id);
        // dd($carrito);
        $detalle_carrito = detalle_carrito::where('carrito_id', $carrito->id)
        ->join('productos','productos.id','=','detalle_carritos.producto_id')
        ->select('detalle_carritos.*','productos.nombre','productos.descripcion','productos.imagen')
        ->get();

        return response([
            'carrito' => $detalle_carrito,

        ],200);
    }

            public function addToCart(Request $request)
        {
            $id = auth()->user()->id;
            $carritoUsuario = Carrito::where('cliente_id', $id)->first();

            if (!$carritoUsuario) {
                $carritoUsuario = new Carrito();
                $carritoUsuario->cliente_id = $id;
                $carritoUsuario->total = 0; // Inicializar el total en cero para un nuevo carrito
                $carritoUsuario->save();
            }

            $detalle_carrito = new detalle_carrito();
            $detalle_carrito->carrito_id = $carritoUsuario->id;
            $detalle_carrito->producto_id = $request->producto_id;
            $detalle_carrito->cantidad = $request->cantidad;
            $detalle_carrito->precio = $request->producto_precio;
            $detalle_carrito->save();

            // Actualizar el total del carrito sumando el precio del producto agregado
            $carritoUsuario->total += ($request->producto_precio * $request->cantidad);
            $carritoUsuario->save();

            return response()->json(['message' => 'Producto añadido al carrito']);
        }


}