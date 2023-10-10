<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Especie;

class EspecieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $especies = Especie::all();
        return view('VistaEspecie.index',compact('especies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('VistaEspecie.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $especie = new Especie();
        $especie->nombre = $request->nombre;
        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('public/AvataresPacientes');
            $rutaRelativa = str_replace('public/', '', $imagenPath);
            $especie->imagen_path = $rutaRelativa;
        }
        
        $especie->save();
        return redirect()->route('Especie.index');
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
        $especie = Especie::findOrFail($id);
        return view('VistaEspecie.edit', compact('especie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $validatedData = $request->validate([
            'nombre' => 'required|max:255',
            'imagen' => 'image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);
        $especie = Especie::findOrFail($id);

        $especie->nombre = $request->input('nombre');

        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('ruta_de_almacenamiento'); 
            $especie->imagen_path = $imagenPath;
        }

        $especie->save();

        return redirect()->route('Especie.index')->with('success', 'Especie actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function buscarEspecieIndex(Request $request){
        $texto = $request->input('texto');
        $especies = Especie::where('nombre','LIKE', "%$texto%")->get();
        return view('_resultadoEspecie', compact('especies'));

    }

    public function buscarEspecie(Request $request){
        $texto = $request->input('texto');
        $especies = Especie::where('nombre','LIKE', "%$texto%")->get();
        return view('_resultadoEspecie_PacienteCreate', compact('especies'));

    }

    public function buscarEspecieImagen(Request $request){
        $nombre = $request->input('texto');
        $especie = Especie::where('nombre', $nombre)->first();
        if($especie){
            return response()->json(['imagenUrl' => $especie->imagen_path]);
        }else{
            $imagenUrl = "AvataresPacientes/can.jpg";
            return response()->json(['imagenUrl' => $imagenUrl]);
        }
        
    }
}
