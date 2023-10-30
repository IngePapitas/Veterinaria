<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Spatie\Activitylog\Models\Activity;

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
}
