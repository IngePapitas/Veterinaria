<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Especie;
use App\Models\Medicamento;
use App\Models\NotaServicio;
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
        $personals = Personal::all();
        $allRazas = Raza::all();
        $allEspecies = Especie::all();
        $allServicios = Servicio::all();
        $allMedicamentos = Medicamento::all();
        $servicios = [];
        $medicamentos = [];
        return view('VistaNotaServicio.create', compact('clientes','pacientes', 'personals', 'especies', 'razas','allRazas', 'allEspecies', 'servicios','allServicios','medicamentos','allMedicamentos'));
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
}
