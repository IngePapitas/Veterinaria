<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\carrito;
use App\Models\detalle_carrito;
use Illuminate\Http\Request;

class EfectivoController extends Controller
{
    //
    public function mostrarPagoEfectivo(Request $request)
    {
        $user = auth()->user();
        $carrito = carrito::where('cliente_id', $user->id)->first();
        $detalle_carrito = detalle_carrito::where('carrito_id', $carrito->id)->with('producto')->get();
        $metodopago = 'efectivo';
        return view('continuarefectivo', compact('detalle_carrito', 'carrito', 'metodopago'));
    }
}
