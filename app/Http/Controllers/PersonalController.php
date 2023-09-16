<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personal;
use App\Models\Especialidad;

class PersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $personals = Personal::all();
        return view('VistaPersonal.index', compact('personals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $especialidades = [];
        return view('VistaPersonal.create', compact('especialidades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $personal = new Personal();
        $personal->ci = $request->ci;
        $personal->nombre = $request->nombre;
        $personal->telefono = $request->sueldo;
        $personal->imagen_path = $request->imagen_path;
        $personal->baja = false;
        $personal->estado = false;
        $personal->sueldo = $request->sueldo;
        
        $especialidad = Especialidad::where('descripcion', $request->especialidad)->first();

        if(!$especialidad){
            $especialidad = new Especialidad();
            $especialidad->descripcion = $request->especialidad;
            $especialidad->save();
        }
        
        $personal->id_especialidad = $especialidad->id; 
        $personal->save();
        return redirect()->route('Personal.index');
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

    public function buscarPersonal(Request $request){
        $texto = $request->input('texto');
        $ordenarPor = $request->input('ordenar', 'id');

    switch ($ordenarPor) {
        case 'salario-desc':
            $personals = Personal::where('nombre', 'LIKE', "%$texto%")->orderBy('precio', 'desc')->get();
            break;
        case 'salario-asc':
            $personals = Personal::where('nombre', 'LIKE', "%$texto%")->orderBy('precio', 'asc')->get();
            break;
        case 'stock-desc':
            $personals = Personal::where('nombre', 'LIKE', "%$texto%")->orderBy('especialidad')->get();
            break;
        case 'stock-asc':
            $personals = Personal::where('nombre', 'LIKE', "%$texto%")->orderBy('turno')->get();
            break;
        default:
            $personals = Personal::where('nombre', 'LIKE', "%$texto%")->orderBy('id')->get();
            break;
    }

    return view('_resultadoPersonal', compact('personals'));
    }
}
