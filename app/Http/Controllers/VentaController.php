<?php

namespace App\Http\Controllers;

use App\Models\carrito;
use App\Models\detalle_carrito;
use App\Models\detalle_venta;
use App\Models\producto;
use App\Models\venta;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id = auth()->user()->id;
        $compras = venta::where('cliente_id', $id)->orderBy('id', 'desc')->get();
        $venta = venta::where('cliente_id', $id)
            ->join('detalle_ventas', 'detalle_ventas.venta_id', '=', 'ventas.id')
            ->join('productos', 'productos.id', '=', 'detalle_ventas.producto_id')
            ->select('ventas.*', 'detalle_ventas.cantidad', 'detalle_ventas.precio', 'productos.nombre', 'productos.descripcion', 'productos.imagen', 'productos.precio as punit')
            ->get();

        return view('VistaCarrito.venta', compact('venta', 'compras'));
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
        $id = auth()->user()->id;
        $c = carrito::where('cliente_id', $id)->first();

        $venta = new venta();
        $venta->cliente_id = $id;
        $venta->total = $c->total;
        $venta->forma_pago = "efectivo";
        $venta->save();

        $id_venta = venta::where('cliente_id', $id)->orderBy('id', 'desc')->first();
        $d = detalle_carrito::where('carrito_id', $c->id)->get();

        foreach ($d as $detalle) {
            $dv = new detalle_venta();
            $dv->venta_id = $id_venta->id;
            $dv->producto_id = $detalle->producto_id;
            $dv->cantidad = $detalle->cantidad;
            $dv->precio = $detalle->precio * $detalle->cantidad;
            $dv->save();

            $p = producto::where('id', $detalle->producto_id)->first();
            $p->stock = $p->stock - $detalle->cantidad;
            $p->save();

            $detalle->delete();
            $c->total = 0;
            $c->save();
            // return redirect()->route('venta.index')->with('success', 'Compra realizada con éxito');
        }
        activity()
            ->causedBy(auth()->user()) // El usuario responsable de la actividad
            ->log('Realizo una compra ' );
        return redirect()->route('venta.index')->with('success', 'Compra realizada con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(venta $venta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(venta $venta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, venta $venta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(venta $venta)
    {
        //
    }
}
