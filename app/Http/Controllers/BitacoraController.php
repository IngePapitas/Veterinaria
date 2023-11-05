<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Google_Client;
use Illuminate\Support\Facades\View;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Swift_Attachment;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class BitacoraController extends Controller
{
    //
    public function index(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        if ($start_date && $end_date) {
            // Se proporcionó un rango de fechas, aplicar el filtro
            $activities = Activity::whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->get();
        } else {
            // No se proporcionó un rango de fechas, cargar todas las actividades
            $activities = Activity::all();
        }

        if ($request->ajax()) {
            $view = View::make('partials.activities_table', compact('activities'))->render();

            return response()->json([
                'view' => $view
            ]);
        }

        return view('VistaBitacora.index', compact('activities'));
    }

    public function twosteps(){
        $usuario = Auth::user();
        $rol = $usuario->roles->first();
        return view('VistaBitacora.twosteps', compact('usuario', 'rol'));
    }

    public function verificarContrasena(Request $request){
        $usuarioRecibido = $request->input('usuario');
        $user = User::findOrFail($usuarioRecibido);

        $contrasenaIngresada = $request->input('texto');

    if (Hash::check($contrasenaIngresada, $user->password)) {
        return response()->json(true);
    }

        return response()->json(false);
    }

    public function mandarClave(Request $request){
        try {

            $usuario = User::findOrFail($request->input('usuario'));
            if ($usuario) {
                $claveAleatoria = Str::random(6);

                $refreshToken = '1//045l57gKGvVWzCgYIARAAGAQSNwF-L9IrQBXX7PUG1Liy5qQusroQKaHAtFM7Gx6IN4m10UB7X2uKTHh8f3k5IxPF194thtw3iPc';
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

                    $message = (new Swift_Message('VetLink'))
                        ->setFrom(['vetlink91@gmail.com' => 'VetLink'])
                        ->setTo([$usuario->email => $usuario->name])
                        ->setBody('CLAVE TEMPORAL DE ACCESO A BITACORA: '. $claveAleatoria);
                        

                    $mailer->send($message);
                

                return response()->json($claveAleatoria);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function verificarClaveUnica(Request $request){
        $clave = $request->input('claveInput');
        $clave1 = $request->input('clave');
        if($clave1 == $clave){
            return redirect()->route('Bitacora.index');
        }else{
            return redirect()->route('Dashboard');
        }
    }
}
