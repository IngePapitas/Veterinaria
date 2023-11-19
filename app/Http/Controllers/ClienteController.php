<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\NotaServicio;
use App\Models\User;
class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::all();
        return view('VistaCliente.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('VistaCliente.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cliente = new Cliente();
        $cliente->ci = $request->input('ci');
        $cliente->nombre = $request->input('nombre');
        $cliente->correo = $request->input('correo');
        $cliente->telefono = $request->input('telefono');
        $cliente->save();
        $usercliente = new User();
        $usercliente->name = $request->input('nombre');
        $usercliente->email = $request->input('correo');
        $usercliente->password = bcrypt('password');
        $usercliente->save();
        activity()
            ->causedBy(auth()->user())//usuario responsable de actividad
            ->log('Registro al nuevo cliente: '. $cliente->nombre);
        
        return redirect()->route('Cliente.index')->with('success', 'Cliente creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('VistaCliente.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->ci = $request->input('ci');
        $cliente->nombre = $request->input('nombre');
        $cliente->correo = $request->input('correo');
        $cliente->telefono = $request->input('telefono');
        $cliente->save();

        activity()
        ->causedBy(auth()->user())//usuario responsable de actividad
        ->log('Edito a informacion de un cliente: '. $cliente->nombre);

        return redirect()->route('Cliente.index')->with('success', 'Cliente actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);

        $notasVentasRelacionadas = NotaServicio::where('id_cliente', $id)->get();

        foreach ($notasVentasRelacionadas as $notaVenta) {

            $notaVenta->id_cliente = null;
            $notaVenta->save();
        }

        activity()
        ->causedBy(auth()->user())//usuario responsable de actividad
        ->log('Elimino al cliente: '. $cliente->cliente);

        $cliente->delete();

        return redirect()->route('Cliente.index');
    }

    public function buscarClientes(Request $request)
    {
        $texto = $request->input('texto');
        $clientes = Cliente::where('nombre', 'LIKE', "%$texto%")->get();

        return view('_resultadosClientes', compact('clientes'));
    }
}
