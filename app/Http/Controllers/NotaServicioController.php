<?php

namespace App\Http\Controllers;

use App\Models\Alergia;
use App\Models\Cita;
use App\Models\Cliente;
use App\Models\Especie;
use App\Models\EstadoPaciente;
use App\Models\Medicamento;
use App\Models\NotaServicio;
use App\Models\NotaServicioMedicamento;
use App\Models\NotaServicioServicio;
use App\Models\Paciente;
use App\Models\Personal;
use App\Models\Raza;
use App\Models\Registro;
use App\Models\Servicio;
use App\Models\Vacuna;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotaServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
            $servicios = NotaServicio::servicios();
    
            
        return view('VistaNotaServicio.index', compact('servicios'));
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
        $personals = Personal::getAllEspecialidad();
        $allRazas = Raza::all();
        $allEspecies = Especie::all();
        $allServicios = Servicio::all();
        $allMedicamentos = Medicamento::all();
        $allAlergias = Alergia::all();
        $estados = EstadoPaciente::all();
        $servicios = [];
        $medicamentos = [];
        $vacunas = Vacuna::all();
        return view('VistaNotaServicio.create', compact('clientes', 'pacientes', 'personals', 'especies', 'razas', 'allRazas', 'allEspecies', 'servicios', 'allServicios', 'medicamentos', 'allMedicamentos', 'estados', 'vacunas','allAlergias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request);
        if ($request->codigo == null) {
            $paciente = new Paciente();
            $paciente->nombre = $request->nombre;
            $paciente->peso = $request->peso;
            $paciente->tamano = $request->tamano;
            $especie = Especie::where('nombre', $request->especie)->first();
            if (!$especie) {
                $especie = new Especie();
                $especie->nombre = $request->especie;
                $especie->save();
            }
            $paciente->id_especie = $especie->id;
            $raza = Raza::where('nombre', $request->raza)
                ->where('id_especie', $especie->id)->first();
            if (!$raza) {
                $raza = new Raza();
                $raza->nombre = $request->raza;
                $raza->id_especie = $especie->id;
                $raza->save();
            }
            $paciente->id_raza = $raza->id;
            if ($request->hasFile('imagen')) {
                $imagenPath = $request->file('imagen')->store('public/imagenesPacientes');
                $paciente->imagen_path = $imagenPath;
            }
            $paciente->save();
        } else {
            $paciente = Paciente::findOrFail($request->codigo);
        }
        $cliente = Cliente::where('ci', $request->ci_cliente)->first();
        if (!$cliente) {
            $cliente = new Cliente();
            $cliente->ci = $request->input('ci_cliente');
            $cliente->nombre = $request->input('nombre_cliente');
            $cliente->correo = $request->input('correo_cliente');
            $cliente->telefono = $request->input('telefono_cliente');
            $cliente->save();
        }

        $notaservicio = new NotaServicio();
        $notaservicio->id_paciente = $paciente->id;
        $notaservicio->id_cliente = $cliente->id;
        $notaservicio->id_personal = $request->personal;
        $notaservicio->descripcion = $request->descripcionServicio;
        $notaservicio->total = 0;
        $notaservicio->id_estado = $request->estado;
        $notaservicio->save();
        $total = 0;

        if ($request->InputServicios != null) {
            $servicios = explode(',', $request->InputServicios);
            $numeroServicios = count($servicios);
            for ($i = 0; $i < $numeroServicios; $i++) {
                $servicio = Servicio::where('descripcion', $servicios[$i])->first();
                $total += $servicio->precio;
                $notaservicio_servicio = new NotaServicioServicio();
                $notaservicio_servicio->id_notaservicio = $notaservicio->id;
                $notaservicio_servicio->id_servicio = $servicio->id;
                $notaservicio_servicio->save();
            }
        }
        if ($request->InputMedicamentos != null) {
            $medicamentos = explode(',', $request->InputMedicamentos);
            $cantidades = explode(',', $request->InputCantidades);
            $numeromedicamentos = count($medicamentos);
            for ($i = 0; $i < $numeromedicamentos; $i++) {
                $medicamento = Medicamento::where('nombre', $medicamentos[$i])->first();
                $total += $medicamento->precio * $cantidades[$i];
                $notaservicio_medicamento = new NotaServicioMedicamento();
                $notaservicio_medicamento->id_notaservicio = $notaservicio->id;
                $notaservicio_medicamento->id_medicamento = $medicamento->id;
                $notaservicio_medicamento->cantidad = $cantidades[$i];
                $notaservicio_medicamento->subtotal = $medicamento->precio * $cantidades[$i];
                $notaservicio_medicamento->save();
                $medicamento->stock -= $cantidades[$i];
                $medicamento->save();
            }
        }
        if ($request->alergiasSubmit != null) {
            $alergia = explode(',', $request->alergiasSubmit);
            $numeromedicamentos = count($alergia);
            for ($i = 0; $i < $numeromedicamentos; $i++) {
                $medicamento = Medicamento::where('nombre', $alergia[$i])->first();
                $alergiaEncontrada = Alergia::where('id_medicamento',$medicamento->id)
                ->where('id_paciente',$paciente->id)->first();
                if(!$alergiaEncontrada){
                    $alergiaEncontrada = new Alergia();
                    $alergiaEncontrada->id_medicamento = $medicamento->id;
                    $alergiaEncontrada->id_paciente = $paciente->id;
                    $alergiaEncontrada->save();
                }
                
            }
            
        }
        $notaservicio->total = $total;
        $notaservicio->save();

        $now = Carbon::now();

        $citaAnterior = Cita::getCitaAnterior($paciente->id, $request->personal);
        //dd($citaAnterior);
        if ($citaAnterior) {
            $citaAnteriorEncontrada = Cita::findOrFail($citaAnterior->id);
            $citaAnteriorEncontrada->estado = 1;
            $citaAnteriorEncontrada->visitado = $now;
            $citaAnteriorEncontrada->save();
        }

        if ($request->input('fecha_cita')) {
            if (!empty($request->input('selTipoVac')) && ($request->input('selTipoVac') != null)) {
                if (($request->input('checkboxPlan')) == "on") {
                    $vacunaSel = Vacuna::where('id', $request->input('selVacunasPlan'))->first();
                    $intervaloSel = $vacunaSel->intervalo;
                    $vacunasEspecie = Vacuna::where('id_especie', $vacunaSel->id_especie)
                        ->where('intervalo', '>=', $vacunaSel->intervalo)
                        ->get();

                    foreach ($vacunasEspecie as $vacunaEspecie) {
                        $cita = new Cita();
                        $cita->id_paciente = $paciente->id;
                        $cita->id_personal = $request->personal;
                        $fechaIni = $request->input('fecha_cita');
                        $intervalo = $vacunaEspecie->intervalo - $intervaloSel;
                        $nuevaFecha = date('Y-m-d', strtotime("$fechaIni + $intervalo days"));
                        $cita->fecha = $nuevaFecha;
                        if ($request->input('hora_cita')) {
                            $cita->hora = $request->input('hora_cita');
                        }
                        $cita->descripcion = $vacunaEspecie->nombre;
                        $cita->tipo = 1;
                        $cita->estado = 0;
                        $cita->save();
                    }
                } else {
                    $vacunaSel = Vacuna::where('id', $request->input('selVacunasUnica'))->first();
                    $cita = new Cita();
                    $cita->id_paciente = $paciente->id;
                    $cita->id_personal = $request->personal;
                    $cita->fecha = $request->input('fecha_cita');
                    if ($request->input('hora_cita')) {
                        $cita->hora = $request->input('hora_cita');
                    }
                    $cita->descripcion = $vacunaSel->nombre;
                    $cita->tipo = 1;
                    $cita->estado = 0;
                    $cita->save();
                }
            } else {
                $cita = new Cita();
                $cita->id_paciente = $paciente->id;
                $cita->id_personal = $request->personal;
                $cita->fecha = $request->input('fecha_cita');
                if ($request->input('hora_cita')) {
                    $cita->hora = $request->input('hora_cita');
                }
                $cita->tipo = 0;
                $cita->estado = 0;
                $cita->save();
            }
        }

        $cantidadDivs = $request->input('cantidadDivs');
        for ($i = 0; $i < $cantidadDivs; $i++) {
            $registro = new Registro();
            $registro->id_nota = $notaservicio->id;
            $registro->descripcion = $request->input('texto_div' . $i);
            $tipoArchivo = $request->input('tipoArchivo_div' . $i);
            if($tipoArchivo == 'foto'){
                if ($request->hasFile('archivo_div'. $i)) {
                    $imagenPath = $request->file('archivo_div'. $i)->store('public/fotosServicios');
                    $registro->path_archivo = $imagenPath;
                    $registro->tipo_archivo = '2';
                }
            }else{
                if ($request->hasFile('archivo_div'. $i)) {
                    $imagenPath = $request->file('archivo_div'. $i)->store('public/documentosServicios');
                    $registro->path_archivo = $imagenPath;
                    $registro->tipo_archivo = '1';
                }
            }
            $registro->save();
        }



        $datos = [
            'nombre_cliente' => $cliente->nombre,
            'nombre_paciente' => $paciente->nombre,
            'total_servicio' => $notaservicio->total,
            'descripcion' => $notaservicio->descripcion,
            'fecha' => $notaservicio->created_at,
        ];
        // Mail::to($cliente->correo)->send(new NotaServicioMailable($datos));

        activity()
            ->causedBy(auth()->user()) //usuario responsable de actividad
            ->log('Creo la nota de servicio para el paciente: ' . $paciente->nombre);

        return redirect()->route('NotaServicio.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $servicioRealizado = NotaServicioServicio::getDetalles($id);
        $encabezado = NotaServicio::detalles($servicioRealizado->id_notaservicio);
        $notasDocumentos = Registro::where('id_nota',$servicioRealizado->id_notaservicio)
        ->where('tipo_archivo','1')->get();
        $notasImagenes = Registro::where('id_nota',$servicioRealizado->id_notaservicio)
        ->where('tipo_archivo','2')->get(); 
        $notas = Registro::where('id_nota',$servicioRealizado->id_notaservicio)
        ->where('tipo_archivo', null)->get();
        $historial = NotaServicioServicio::historialServicios($encabezado->id_paciente);

        return view('VistaNotaServicio.show', compact('encabezado', 'notas','notasImagenes' ,'notasDocumentos','servicioRealizado','historial'));
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

    public function obtenerServiciosRequeridos(Request $request)
    {
        try {
            $fechaIni = !empty($request->input('fechaIni')) ? $request->input('fechaIni') : '';
            $fechaFin = !empty($request->input('fechaFin')) ? $request->input('fechaFin') : '';
            $data = NotaServicio::obtenerServiciosRequeridos($fechaIni, $fechaFin);

            $cantidadProductos = 0;

            foreach ($data as $item) {
                $cantidadProductos += $item->cantidad;
            }

            foreach ($data as $item) {
                $item->porcentaje = round($item->cantidad * 100 / $cantidadProductos, 1);
                $item->nameservicio = $item->servicio;
            }

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
