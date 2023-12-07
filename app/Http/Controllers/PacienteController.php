<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Especie;
use App\Models\NotaServicio;
use App\Models\Raza;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pacientes = Paciente::getTabla();
        return view('VistaPaciente.index', compact('pacientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $especies = [];
        $razas = [];
        return view('VistaPaciente.create', compact('especies','razas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $especie = Especie::where('nombre', $request->especie)->first();
        if(!$especie){
            $especie = new Especie();
            $especie->nombre = $request->especie;
            $especie->save();
        }
        $raza = Raza::where('nombre', $request->raza)
            ->where('id_especie', $especie->id)
            ->first();

        if(!$raza){
            $raza = new Raza();
            $raza->nombre = $request->raza;
            $raza->id_especie = $especie->id;
            $raza->save();
        }

        $paciente = new Paciente();
        $paciente->nombre = $request->nombre;
        $paciente->peso = $request->peso;
        $paciente->tamano = $request->tamano;
        $paciente->id_especie = $especie->id;
        $paciente->id_raza = $raza->id;
        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('public/imagenesPacientes');
            $paciente->imagen_path = $imagenPath;
        }
        $paciente->save();

        activity()
        ->causedBy(auth()->user())//usuario responsable de actividad
        ->log('Registro al paciente: '. $paciente->nombre);

        return redirect()->route('Paciente.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $paciente = Paciente::getDatos($id);
        $historial = Paciente::getNotasServicio($id);
        $allNotasServicio = NotaServicio::allData();
        $duenos = NotaServicio::allDuenos();
        $tieneCirujias = NotaServicio::cirujias($id);
        $personal = '';
        $citaPendiente = Cita::getCitaAnterior($id, $personal);

        $vacunas = Cita::where('id_paciente',$id)
        ->where('tipo', 1)
        ->get();

        return view ('VistaPaciente.show',compact('paciente','historial','allNotasServicio','duenos', 'citaPendiente', 'vacunas','tieneCirujias'));
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $paciente = Paciente::findORFail($id);
        $especies = [];
        $razas = [];
        
        return view('VistaPaciente.edit', compact('paciente','especies','razas'));
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

    public function buscarPaciente(Request $request){
        $texto = $request->input('texto');
        $ordenarPor = $request->input('ordenar');
        $pacientes = Paciente::select('pacientes.*','razas.nombre as raza','especies.nombre as especie','especies.imagen_path as especie_imagen')
        ->join('especies', 'razas.id_especie', '=', 'especies.id')
        ->join('razas', 'razas.id', '=', 'pacientes.id_raza')
        ->where(function ($query) use ($texto) {
            $query->where('especies.nombre', 'LIKE', "%$texto%")
                ->orWhere('razas.nombre', 'LIKE', "%$texto%")
                ->orWhere('pacientes.nombre', 'LIKE', "%$texto%");
        })
        ->orderBy($ordenarPor === 'nombre' ? 'pacientes.nombre' : 'pacientes.id')
        ->get();
    
    return view('_resultadoPaciente', compact('pacientes'));
    }

    public function buscarServiciosShow(Request $request) {
        try {
            $servicios_ns = NotaServicio::getServicios($request->input('id'));
            return response()->json($servicios_ns);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function buscarMedicamentosShow(Request $request) {
        try {
            $medicamentos_ns = NotaServicio::getMedicamentos($request->input('id'));
            return response()->json($medicamentos_ns);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function cirujia(string $id){
        $paciente = Paciente::findOrFail($id);
        $cirujias = NotaServicio::cirujias($id);

        return view('VistaPaciente.cirujia', compact('paciente','cirujias'));
    }
    
}
