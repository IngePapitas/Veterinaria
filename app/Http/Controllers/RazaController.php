<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Raza;
use App\Models\Especie;

class RazaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $raza = Raza::all();
        $especie = Especie::all();
        return view('VistaEspecie.indexraza',compact('raza','especie'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $especie = Especie::all();
        return view('VistaEspecie.createraza',compact('especie'));
        
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $r = Raza::find($id);

        
        activity()
                ->causedBy(auth()->user())//usuario responsable de actividad
                ->log('Actualizo la raza: '. $r->nombre);

        return view('VistaEspecie.editraza', compact('r'));
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
    public function destroy($id)
    {
        //
        $raza = Raza::find($id);

        activity()
                ->causedBy(auth()->user())//usuario responsable de actividad
                ->log('Elimino la raza: '. $raza->nombre);

        $raza->delete();

        return redirect()->route('Raza.index')->with('success', 'Raza eliminada correctamente');
    }

    public function buscarRaza(Request $request) {
        $texto = $request->input('texto');
        $especie = $request->input('especie');
        $especieencontrada = Especie::where('nombre', $especie)->first();
        if($especieencontrada){
        $razas = Raza::where('nombre', 'LIKE', "%$texto%")
            ->where('id_especie', $especieencontrada->id)
            ->get();
        
        }
        else{
            $razas = [];
        }
        return view('_resultadoRaza_PacienteCreate', compact('razas'));
    }
    
}
