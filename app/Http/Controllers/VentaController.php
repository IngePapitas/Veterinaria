<?php

namespace App\Http\Controllers;

use App\Models\carrito;
use App\Models\detalle_carrito;
use App\Models\detalle_venta;
use App\Models\producto;
use App\Models\User;
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
        
        // Obtener los detalles de productos para cada venta
        $ventas = [];
        foreach ($compras as $compra) {
            $productosComprados = detalle_venta::where('venta_id', $compra->id)
                ->join('productos', 'productos.id', '=', 'detalle_ventas.producto_id')
                ->select('detalle_ventas.*', 'productos.nombre as producto_nombre', 'productos.descripcion as producto_descripcion')
                ->get();
            
            $ventas[] = [
                'venta' => $compra,
                'productos' => $productosComprados,
            ];
        }

        return view('VistaCarrito.venta', compact('ventas'));
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
    public function notaVenta(venta $id)
    {
        // dd($id);
        $ventas = Venta::where('ventas.id', $id->id)
        ->join('users as cl', 'cl.id', '=', 'ventas.cliente_id')
        ->join('detalle_ventas', 'detalle_ventas.venta_id', '=', 'ventas.id')
        ->join('productos', 'productos.id', '=', 'detalle_ventas.producto_id')
        ->join('users as em', 'em.id', '=', 'ventas.cliente_id') // Reemplaza 'productos.user_id' con el nombre correcto de la columna
        ->select('ventas.id as venta_id', 'ventas.total', 'ventas.forma_pago', 'ventas.created_at as fecha',
            'cl.name as cliente', 'em.name as empresa', 'productos.nombre', 'productos.descripcion',
            'productos.imagen', 'productos.precio as punit', 'detalle_ventas.id as id_detalle',
            'detalle_ventas.cantidad', 'detalle_ventas.precio')
        ->get();

        return view('VistaCarrito.nota', compact('ventas'));
    }

    public function mostrarCompras()
    {
        $compras = [];

        $comprasDB = Venta::all();

        foreach ($comprasDB as $compra) {
            $productosComprados = detalle_venta::where('venta_id', $compra->id)
                ->join('productos', 'productos.id', '=', 'detalle_ventas.producto_id')
                ->select('detalle_ventas.*', 'productos.nombre', 'productos.precio')
                ->get();

            $cliente = User::find($compra->cliente_id);
            $cliente_nombre = $cliente ? $cliente->name : 'Cliente no encontrado';

            $precioTotalCompra = 0;

            foreach ($productosComprados as $producto) {
                $producto->precio_total = $producto->precio * $producto->cantidad;
                $precioTotalCompra += $producto->precio_total;
            }
            
            $metodopago = ''; // Inicializa el tipo de pago

            if ($compra->forma_pago === 'efectivo') {
                $metodopago = 'Efectivo';
            } elseif ($compra->forma_pago === 'tarjeta') {
                $metodopago = 'Tarjeta';
            }

            $compras[] = [
                'cliente' => $cliente_nombre,
                'fecha' => $compra->created_at,
                'productos' => $productosComprados,
                'precioTotalCompra' => $precioTotalCompra, // Pasa el precio total de compra
                'tipoPago' => $metodopago,
            ];
        }

        return view('compraclientes', compact('compras'));
    }


    public function obtenerNombreCliente($cliente_id)
    {
        $cliente = User::find($cliente_id);
        return $cliente ? $cliente->nombre : 'Cliente no encontrado';
    }
}
