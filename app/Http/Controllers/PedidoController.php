<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\marca;
use App\Models\producto;
use App\Models\proveedor;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    //
    public function index()
    {
        $arrayProductos = [];
        $productos = producto::whereRaw('stock <= stock_min')->get();

        foreach ($productos as $p) {
            $marca = marca::where('id', $p->marca_id)->first();
            $proveedores = proveedor::where('marca_id', $p->marca_id)->get();
            $arrayProductos[] = [
                "producto_id"    => $p->id,
                "producto_nombre"    => $p->nombre,
                "producto_descripcion"    => $p->descripcion,
                "producto_stock"     => $p->stock,
                "producto_stock_min" => $p->stock_min,
                "marca"              => $marca->nombre,
                "proveedor"          => $proveedores,
            ];
        }

        return view('VistaPedido.index', compact('arrayProductos'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $compra = Compra::create([
            // Agregar los atributos de la compra
        ]);
        $compra->save();
        $stocks = $request->input('stock');
        $id = $request->input('id_producto');
        $prov = $request->input('proveedor');
        $contador = 0;
        foreach ($stocks as $cantidad) {
            // dd($id[$contador]);
            $proveedor = proveedor::where('id','=',$prov[$contador])->first();
            $producto = Producto::where('id','=',$id[$contador])->first();
            if($cantidad > 0){
            $detallecompra = DetalleCompra::create([
                'compra_id' => $compra->id,
                'producto_id' => $producto->id,
                'cantidad'  => $cantidad,
                'proveedor_id' => $proveedor->id,
        ]);

            $detallecompra->save();
        }
            $producto->stock += $cantidad;
            // dd($producto);
            $producto->save();
            $contador++;
        }
        activity()
            ->causedBy(auth()->user()) // El usuario responsable de la actividad
            ->log('Se realizo un pedido de compra al proveedor ' );
        // Aquí puedes realizar otras acciones relacionadas con el pedido,
        // como almacenar la información en la base de datos, enviar notificaciones, etc.

        return redirect()->route('compra.index')->with('success', 'Pedido solicitado correctamente.');
    }

}
