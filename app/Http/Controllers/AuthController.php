<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use App\Models\Cita;
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

    public function citas(){
        $citas = Cita::where('user_id', Auth::user()->id)->get();
        return response([
            'citas' => $citas
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



}