<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoriaMedicamento;
use App\Models\Medicamento;
use App\Models\Laboratorio;
use App\Models\NotaServicio;

class MedicamentoController extends Controller
{
    public function index()
    {
        $medicamentos = Medicamento::all();
        return view('VistaMedicamento.index', compact('medicamentos'));
    }

    public function create()
    {
        $laboratorios = [];
        $categoriamedicamentos = [];
        return view('VistaMedicamento.create', compact('laboratorios','categoriamedicamentos'));
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
        $categoriamedicamentos = CategoriaMedicamento::all();
        $laboratorios = Laboratorio::all();
        return view('VistaMedicamento.edit', compact('medicamento','categoriamedicamentos','laboratorios'));
    }

    public function update(Request $request, $id)
    {
        // Obtener el registro existente del medicamento
        $medicamento = Medicamento::findOrFail($id);

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
        $medicamentos = Medicamento::with('laboratorio')->get();
        $medicamentos = Medicamento::with('categoriaMedicamento')->get();

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

    public function buscarMedicamento(Request $request){
        $texto = $request->input('texto');
        $ordenarPor = $request->input('ordenar', 'id');
        
        $medicamentos = Medicamento::select('medicamentos.*')
            ->join('categoria_medicamentos', 'medicamentos.id_categoriamedicamento', '=', 'categoria_medicamentos.id')
            ->join('laboratorios', 'medicamentos.id_laboratorio', '=', 'laboratorios.id')
            ->where(function ($query) use ($texto) {
                $query->where('medicamentos.nombre', 'LIKE', "%$texto%")
                    ->orWhere('categoria_medicamentos.nombre', 'LIKE', "%$texto%")
                    ->orWhere('laboratorios.nombre', 'LIKE', "%$texto%");
            })
            ->orderBy($ordenarPor === 'precio-desc' ? 'precio' : 'id', $ordenarPor === 'precio-asc' ? 'asc' : 'desc')
            ->get();
        
        return view('_resultadoMedicamento', compact('medicamentos'));
    }

    public function buscarMedicamentosCreate(Request $request){
        try {
            $texto = $request->input('texto');
            $medicamentos = Medicamento::where('nombre', 'LIKE', "%$texto%")->get();
            return view('_resultadoMedicamentos_CreateNS', compact('medicamentos'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function obtenerIngresosMedicamentos(Request $request)
    {
        try {
            $fechaIni = !empty($request->input('fechaIni')) ? $request->input('fechaIni'): '';
            $fechaFin = !empty($request->input('fechaFin'))? $request->input('fechaFin'): '';
            $medicamento = !empty($request->input('medicamento'))? $request->input('medicamento'): '';

            $consulta = NotaServicio::obtenerIngresosMedicamentos($fechaIni, $fechaFin, $medicamento);

            return response()->json($consulta);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
