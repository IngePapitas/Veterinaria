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
