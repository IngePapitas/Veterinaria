<?php

namespace App\Http\Controllers;

use App\Models\NotaServicio;
use App\Models\Servicio;
use App\Models\TipoServicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $servicios = Servicio::all();
        return view('VistaServicio.index', compact('servicios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tipoServicios = TipoServicio::all();
        return view('VistaServicio.create', compact('tipoServicios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required',
            'precio' => 'required|numeric',
        ]);

        $servicio = new Servicio();
        $servicio->descripcion = $request->input('descripcion');
        $servicio->precio = $request->input('precio');
        $servicio->id_tipo_servicio = $request->input('tipo_servicio');
        
        activity()
                ->causedBy(auth()->user())//usuario responsable de actividad
                ->log('Creo un nuevo Servicio: '. $servicio->descripcion);

        $servicio->save();

        return redirect()->route('Servicio.index')->with('success', 'Servicio creado correctamente.');
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
        $tipoServicios = TipoServicio::all();
        $servicio = Servicio::find($id);
        return view('VistaServicio.edit', compact('servicio','tipoServicios'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'descripcion' => 'required',
            'precio' => 'required|numeric',
        ]);

        $servicio = Servicio::find($id);
        $servicio->descripcion = $request->input('descripcion');
        $servicio->precio = $request->input('precio');
        $servicio->id_tipo_servicio = $request->input('tipo_servicio');
        $servicio->save();
        
        activity()
                ->causedBy(auth()->user())//usuario responsable de actividad
                ->log('Actualizo el Servicio: '. $servicio->nombre);

        return redirect()->route('Servicio.index')->with('success', 'Servicio actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $servicio = Servicio::find($id);
        
        activity()
                ->causedBy(auth()->user())//usuario responsable de actividad
                ->log('Elimino el Servicio: '. $servicio->nombre);

    }
    public function buscarServicios(Request $request)
    {
        $texto = $request->input('texto');
        $servicios = Servicio::where('descripcion', 'LIKE', "%$texto%")->get();

        return view('_resultadosServicios', compact('servicios'));
    }

    public function buscarServiciosCreate(Request $request)
    {
        try {
            $texto = $request->input('texto');
            $servicios = Servicio::where('descripcion', 'LIKE', "%$texto%")->get();
            return view('_resultadoServicios_CreateNS', compact('servicios'));
        } catch (\Exception $e) {
            // Captura cualquier excepción y muestra el mensaje de error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function obtenerIngresosServicios(Request $request)
    {
        try {
            $fechaIni = !empty($request->input('fechaIni')) ? $request->input('fechaIni'): '';
            $fechaFin = !empty($request->input('fechaFin'))? $request->input('fechaFin'): '';
            $servicio = !empty($request->input('servicio'))? $request->input('servicio'): '';

            $consulta = NotaServicio::obtenerIngresosServicios($fechaIni, $fechaFin, $servicio);

            return response()->json($consulta);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
