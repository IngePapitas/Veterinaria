<?php

namespace App\Http\Controllers;
use App\Models\valoracion;
use Illuminate\Http\Request;

class valoracionController extends Controller
{
    public function index(){
        $valoraciones = valoracion::all();
        return view('VistaValoracion.index', compact('valoraciones'));
    }
}
