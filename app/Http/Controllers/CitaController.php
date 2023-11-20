<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Paciente;
use App\Models\Personal;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $personal = '';
        $paciente = '';
        $personals = Personal::all();
        $pacientes = Paciente::all();

        $citas = Cita::allData($personal, $paciente);
        return view('VistaCita.index', compact('citas','personals','pacientes'));
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
        $cita = Cita::findOrFail($id);
        $personals = Personal::all();
        return view('VistaCita.edit', compact('cita','personals'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'fecha' => 'required|date',
            'hora' => 'required',
            'id_personal' => 'required|exists:personals,id',
        ]);

        $cita = Cita::findOrFail($id);

        $cita->fecha = $request->input('fecha');
        $cita->hora = $request->input('hora');
        $cita->id_personal = $request->input('id_personal');
        // Otros campos que puedas tener en la tabla cita

        $cita->save();

        return redirect()->route('Cita.index')->with('success', 'Cita actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function buscarCitas(Request $request)
    {
        $personal = $request->input('personal');
        $paciente = $request->input('paciente');
        $citas = Cita::allData($personal, $paciente);
        return view('_resultadosCitas', compact('citas'));
    }
}
