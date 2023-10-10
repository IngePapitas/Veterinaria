<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoriaMedicamento;
use App\Models\Medicamento;
use App\Models\Laboratorio;

class MedicamentoController extends Controller
{
    public function index()
    {
        $medicamentos = Medicamento::all();
        return view('VistaMedicamento.index', compact('medicamentos'));
    }

    public function create()
    {
        $laboratorio = [];
        return view('VistaMedicamento.create', compact('laboratorio'));
    }

    public function store(Request $request)
    {
        // Valida y guarda el medicamento en la base de datos
        $medicamento = new Medicamento();
        $medicamento->nombre = $request->nombre;
        $medicamento->descripcion = $request->descripcion;
        $medicamento->forma_farmaceutica = $request->forma_farmaceutica;
        $medicamento->dosis = $request->dosis;
        $medicamento->precio = $request->precio;
        $medicamento->stock = $request->stock;

        //agregar una nueva categoria de medicamento si no lo hay
        $categoriaMedicamento = CategoriaMedicamento::where('nombre', $request->categoriaMedicamento)->first();
        if(!$categoriaMedicamento){
            $categoriaMedicamento = new CategoriaMedicamento();
            $categoriaMedicamento->nombre = $request->categoriaMedicamento;
            $categoriaMedicamento->save();
        }
        $medicamento->id_categoriamedicamento = $categoriaMedicamento->id;

        //agregar un nuevo laboratorio si no lo hay
        $laboratorio = Laboratorio::where('nombre', $request->laboratorio)->first();
        if(!$laboratorio){
            $laboratorio = new Laboratorio();
            $laboratorio->nombre = $request->laboratorio;
            $laboratorio->save();
        }
        $medicamento->id_laboratorio = $laboratorio->id;

        // Guarda el medicamento en la base de datos
        $medicamento->save();
        return redirect()->route('Medicamento.index');
    }

    public function show(Medicamento $medicamento)
    {

    }

    public function edit(string $id)
    {
        $medicamento = Medicamento::findOrFail($id);
        $categoriaMedicamento = CategoriaMedicamento::all();
        $laboratorio = Laboratorio::all();
        return view('medicamentos.edit', compact('medicamento','categoriaMedicamento','laboratorio'));
    }

    public function update(Request $request, $id)
    {
        // Obtener el registro existente del medicamento
        $medicamento = Medicamento::finOrFail($id);

        //Actualizar los campos
        $medicamento->nombre = $request->nombre;
        $medicamento->descripcion = $request->descripcion;
        $medicamento->forma_farmaceutica = $request->forma_farmaceutica;
        $medicamento->dosis = $request->dosis;
        $medicamento->precio = $request->precio;
        $medicamento->stock = $request->stock;

        //Actualizar la categoria de medicamento
        $categoriaMedicamento = CategoriaMedicamento::where('nombre', $request->categoriaMedicamento)->first();
        if(!$categoriaMedicamento){
            $categoriaMedicamento = new CategoriaMedicamento();
            $categoriaMedicamento->nombre = $request->categoriaMedicamento;
            $categoriaMedicamento->save();
        }
        $medicamento->id_categoriamedicamento = $categoriaMedicamento->id;

        //Actualizar el laboratorio
        $laboratorio = Laboratorio::where('nombre', $request->laboratorio)->first();
        if(!$laboratorio){
            $laboratorio = new Laboratorio();
            $laboratorio->nombre = $request->laboratorio;
            $laboratorio->save();
        }
        $medicamento->id_laboratorio = $laboratorio->id;

        $medicamento->save();
        $medicamentos=Medicamento::all();
        return redirect()->route('Medicamento.index',compact('medicamentos'));
    }

    public function destroy($id)
    {
        // Elimina el medicamento de la base de datos
        try{
            $medicamento = Medicamento::findOrFail($id);
            $medicamento->delete(); //elimina el registro del medicamento

            return redirect()->route('Medicamento.index')->with('success', 'Medicamento eliminado correctamente');
        } catch (\Exception $e) {
            return redirect()->route('Medicamento.index')->with('error', 'No se pudo eliminar el Medicamento');
        }
    }
}
