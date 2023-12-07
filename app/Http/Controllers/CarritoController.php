<?php

namespace App\Http\Controllers;

use App\Models\carrito;
use App\Models\detalle_carrito;
use App\Models\producto;
use Illuminate\Http\Request;

class CarritoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id = auth()->user()->id;
        $carrito = carrito::where('cliente_id', $id)->first();
        // dd($id);
        // dd($carrito);
        $detalle_carrito = detalle_carrito::where('carrito_id', $carrito->id)
        ->join('productos','productos.id','=','detalle_carritos.producto_id')
        ->select('detalle_carritos.*','productos.nombre','productos.descripcion','productos.imagen')
        ->get();


        return view('VistaCarrito.index', compact('detalle_carrito', 'carrito'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(carrito $carrito)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(carrito $carrito)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, carrito $carrito)
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

        return redirect()->route('carrito.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,$id)
    {
        $detalle_carrito = detalle_carrito::find($id);

        if ($detalle_carrito) {
            $subtotal = $detalle_carrito->precio * $detalle_carrito->cantidad;
            
            $carrito = Carrito::find($detalle_carrito->carrito_id);
            $carrito->total = $carrito->total - $subtotal;
            $carrito->save();

            $detalle_carrito->delete();
        }

        return redirect()->route('carrito.index');
    }
}
