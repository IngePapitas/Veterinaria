<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Event;

class EventController extends Controller
{
    //
    public function index()
    {
        $all_events = Event::all();
        $events = [];

        foreach ($all_events as $event){
            $events[] = [
                'title' => $event->event,
                'start' => $event->start_date,
                'end' => $event->end_date,
            ];
        }

        return view('VistaEvento.index',compact('events'));
    }

    public function create()
    {
        $events = Event::get();
        return view('VistaEvento.create',compact('events'));
    }

    public function store(Request $request)
    {
        $nuevoEvento = new Event();
        $nuevoEvento->event = $request->input('evento');
        $nuevoEvento->start_date = $request->input('start_date');
        $nuevoEvento->end_date = $request->input('end_date');
        $nuevoEvento->save();

        activity()
            ->causedBy(auth()->user()) // El usuario responsable de la actividad
            ->log('Creo un nuevo evento: ' . $nuevoEvento->event . 'en la fecha de ' . $nuevoEvento->start_date);

        // Puedes redirigir a una ruta específica después de guardar el evento
        return redirect()->route('calendario.vercalendario')->with('success', 'Se creo el evento correctamente');
    }

    public function vercalendario(){
        $events = Event::all();
        return view('VistaEvento.show',compact('events'));
    }


    public function show()
    {
        $events = Event::all();
        return view('VistaEvento.show',compact('events'));
    }

    public function edit($id)
    {
        $evento = Event::findOrFail($id);
        return view('VistaEvento.edit', compact('evento'));
    }

    public function update(Request $request, $id)
    {
        $evento = Event::findOrFail($id);
        $evento->event = $request->input('evento');
        $evento->start_date = $request->input('start_date');
        $evento->end_date = $request->input('end_date');
        $evento->save();

        activity()
            ->causedBy(auth()->user()) // El usuario responsable de la actividad
            ->log('Actualizo el evento: ' . $evento->event);

        return redirect()->route('calendario.vercalendario')->with('success', 'Evento actualizado correctamente');
    }

    public function destroy($id)
    {
        $evento = Event::findOrFail($id);
        activity()
            ->causedBy(auth()->user()) // El usuario responsable de la actividad
            ->log('Eliminio un evento: ' . $evento->event);
        $evento->delete();

        // Puedes redirigir a una ruta específica después de eliminar el evento
        return redirect()->route('calendario.vercalendario')->with('success', 'Evento eliminado correctamente');
    }

}
