<?php

namespace App\Http\Controllers;

use App\Exports\EstadisticasDashboardExports;
use App\Models\Cita;
use App\Models\Cliente;
use App\Models\Medicamento;
use App\Models\NotaServicio;
use App\Models\Paciente;
use App\Models\Servicio;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Google_Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Swift_Attachment;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicamentos = Medicamento::all();
        $servicios = Servicio::all();
        return view('VistaDashboard.index', compact('servicios', 'medicamentos'));
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
    public function generarExcel(Request $request)
    {
        try {
            $data = $request->all();
            return Excel::download(new EstadisticasDashboardExports($data), 'estadisticas.xlsx');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function enviarAdministradores(Request $request)
    {
        try {

            $archivo = $request->file('archivo');
            if ($archivo) {

                $rutaTemporal = $archivo->storeAs('temp', $archivo->getClientOriginalName());
                $nombreArchivo = $archivo->getClientOriginalName();
                //return response()->json($rutaTemporal);
                $refreshToken = '1//04pham9jiTklyCgYIARAAGAQSNwF-L9IryNLO7AXFn0pKSUO22Bq0SOwwohvzEEx__iPhkJV-uthq_jlFVC6dK9ylCKit6MCnE_w';
                $client = new Google_Client();
                $client->setApplicationName('VetLink');
                $client->setClientId('804250747503-tvbvko3rum72ptepgqqfhomnbaq6u73l.apps.googleusercontent.com');
                $client->setClientSecret('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');
                $client->setRedirectUri('https://developers.google.com/oauthplayground');
                $client->setAccessType('offline');
                $client->setApprovalPrompt('force');
                $client->refreshToken($refreshToken);
                $accessToken = $client->getAccessToken();
                $newAccestoken = $accessToken['access_token'];
                $transport = new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls');
                $transport->setUsername('vetlink91@gmail.com');
                $transport->setPassword($newAccestoken);
                $mailer = new Swift_Mailer($transport);

                $usuariosAdministradores = User::whereHas('roles', function ($query) {
                    $query->where('name', 'Admin');
                })->get();

                foreach ($usuariosAdministradores as $user) {
                    $message = (new Swift_Message('VetLink'))
                        ->setFrom(['vetlink91@gmail.com' => 'VetLink'])
                        ->setTo([$user->email => $user->name])
                        ->setBody('REPORTE ESTADISTICO: ')
                        ->attach(
                            Swift_Attachment::fromPath(storage_path('app/' . $rutaTemporal))
                                ->setFilename($nombreArchivo)
                                ->setContentType('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
                        );

                    $mailer->send($message);
                }
                Storage::delete($rutaTemporal);
                return response()->json(['mensaje' => 'Archivo enviado con éxito']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function misMascotas(){
        $usuario = Auth::user();
        $cliente = Cliente::where('correo', $usuario->email)->first();

        if($cliente){
            $pacientes = NotaServicio::getPacientes($cliente->id);
            return view ('VistaWelcome.mismascotas', compact('pacientes'));
        }
    }

    public function reprogramar(Request $request, $pacienteId){
        //dd($request);

        $paciente = Paciente::findOrFail($pacienteId);

        $citaAnterior = Cita::getCitaAnterior($paciente->id);
        $citaAnteriorEncontrada = Cita::where('id', $citaAnterior->id)->first();

        if($citaAnteriorEncontrada){
            $citaAnteriorEncontrada->fecha = $request->input('nuevaFecha');
            $citaAnteriorEncontrada->hora = $request->input('nuevaHora');
            $citaAnteriorEncontrada->save();
        }
        return view('welcome');
    }
}
