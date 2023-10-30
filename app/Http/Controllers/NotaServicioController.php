<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Especie;
use App\Models\EstadoPaciente;
use App\Models\Medicamento;
use App\Models\NotaServicio;
use App\Models\NotaServicioMedicamento;
use App\Models\NotaServicioServicio;
use App\Models\Paciente;
use App\Models\Personal;
use App\Models\Raza;
use App\Models\Servicio;
use Illuminate\Http\Request;

class NotaServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notasservicio = NotaServicio::all();
        return view('VistaNotaServicio.index', compact('notasservicio'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $especies = [];
        $razas = [];
        $pacientes = Paciente::all();
        $clientes = Cliente::all();
        $personals = Personal::getAllEspecialidad();
        $allRazas = Raza::all();
        $allEspecies = Especie::all();
        $allServicios = Servicio::all();
        $allMedicamentos = Medicamento::all();
        $estados = EstadoPaciente::all();
        $servicios = [];
        $medicamentos = [];
        return view('VistaNotaServicio.create', compact('clientes','pacientes', 'personals', 'especies', 'razas','allRazas', 'allEspecies', 'servicios','allServicios','medicamentos','allMedicamentos','estados'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if($request->codigo == null){
            $paciente = new Paciente();
            $paciente->nombre = $request->nombre;
            $paciente->peso = $request->peso;
            $paciente->tamano = $request->tamano;
            $especie = Especie::where('nombre', $request->especie)->first();
            if(!$especie){
                $especie = new Especie();   
                $especie->nombre = $request->especie;
                $especie->save();
            }
            $paciente->id_especie = $especie->id;
            $raza = Raza::where('nombre', $request->raza)
            ->where('id_especie', $especie->id)->first();
            if(!$raza){
                $raza = new Raza();   
                $raza->nombre = $request->raza;
                $raza->id_especie = $especie->id;
                $raza->save();
            }
            $paciente->id_raza = $raza->id;
            if ($request->hasFile('imagen')) {
                $imagenPath = $request->file('imagen')->store('public/imagenesPacientes');
                $paciente->imagen_path = $imagenPath;
            }
            $paciente->save();
        }else{
            $paciente = Paciente::findOrFail($request->codigo);
        }
        $cliente = Cliente::where('ci', $request->ci_cliente)->first();
        if(!$cliente){
            $cliente = new Cliente();
            $cliente->ci = $request->input('ci_cliente');
            $cliente->nombre = $request->input('nombre_cliente');
            $cliente->correo = $request->input('correo_cliente');
            $cliente->telefono = $request->input('telefono_cliente');
            $cliente->save();
        }

        $notaservicio = new NotaServicio();
        $notaservicio->id_paciente = $paciente->id;
        $notaservicio->id_cliente = $cliente->id;
        $notaservicio->id_personal = $request->personal;
        $notaservicio->descripcion = $request->descripcionServicio;
        $notaservicio->total = 0;
        $notaservicio->id_estado = $request->estado;
        $notaservicio->save();
        $total = 0;
        
        if($request->InputServicios != null){
            $servicios = explode(',', $request->InputServicios);
            $numeroServicios = count($servicios);
            for($i = 0; $i < $numeroServicios; $i++){
                $servicio = Servicio::where('descripcion', $servicios[$i])->first();
                $total += $servicio->precio;
                $notaservicio_servicio = new NotaServicioServicio();
                $notaservicio_servicio->id_notaservicio = $notaservicio->id;
                $notaservicio_servicio->id_servicio = $servicio->id;
                $notaservicio_servicio->save();

            }
        }
        if($request->InputMedicamentos != null){
            $medicamentos = explode(',', $request->InputMedicamentos);
            $cantidades = explode(',', $request->InputCantidades);
            $numeromedicamentos = count($medicamentos);
            for($i = 0; $i < $numeromedicamentos; $i++){
                $medicamento = Medicamento::where('nombre', $medicamentos[$i])->first();
                $total += $medicamento->precio * $cantidades[$i];
                $notaservicio_medicamento = new NotaServicioMedicamento();
                $notaservicio_medicamento->id_notaservicio = $notaservicio->id;
                $notaservicio_medicamento->id_medicamento = $medicamento->id;
                $notaservicio_medicamento->cantidad = $cantidades[$i];
                $notaservicio_medicamento->subtotal = $medicamento->precio * $cantidades[$i];
                $notaservicio_medicamento->save();
                $medicamento->stock -= $cantidades[$i];
                $medicamento->save();
            }
        }
        $notaservicio->total = $total;
        $notaservicio->save();

        return redirect()->route('NotaServicio.index');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function obtenerServiciosRequeridos(Request $request){
        try {
            $fechaIni = !empty($request->input('fechaIni')) ? $request->input('fechaIni'): '';
            $fechaFin = !empty($request->input('fechaFin'))? $request->input('fechaFin'): '';
            $data = NotaServicio::obtenerServiciosRequeridos($fechaIni, $fechaFin);

            $cantidadProductos = 0;

            foreach($data as $item){
                $cantidadProductos += $item->cantidad;
            }

            foreach($data as $item){
                $item->porcentaje = round($item->cantidad * 100 / $cantidadProductos, 1);
                $item->nameservicio = $item->servicio;
            }

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
