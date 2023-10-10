<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Especie;
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
        return redirect()->route('Paciente.index');
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
        $paciente = Paciente::findORFail($id);
        return view('VistaPaciente.edit', compact('paciente'));
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
        $ordenarPor = $request->input('ordenar', 'id');
        $pacientes = Paciente::select('pacientes.*')
        ->join('especies', 'pacientes.id_especie', '=', 'especies.id')
        ->join('razas', 'razas.id_especie', '=', 'especies.id')
        ->where(function ($query) use ($texto) {
            $query->where('personals.nombre', 'LIKE', "%$texto%")
                ->orWhere('razas.nombre', 'LIKE', "%$texto%")
                ->orWhere('paciente.nombre', 'LIKE', "%$texto%");
        })
        ->orderBy($ordenarPor === 'nombre' ? 'nombre' : 'id')
        ->get();
    

    return view('_resultadoPaciente', compact('pacientes'));
    }
}
