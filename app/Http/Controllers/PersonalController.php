<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personal;
use App\Models\Especialidad;

class PersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $personals = Personal::all();
        return view('VistaPersonal.index', compact('personals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $especialidades = [];
        return view('VistaPersonal.create', compact('especialidades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         /*else {
            // Si no se proporcionó una imagen, determinar el avatar en función del sexo
            $sexo = $request->input('sexo');
            $avatar = ($sexo === 'Mujer') ? 'AvataresDoctor/AvatarMujer.jpeg' : 'AvataresDoctor/AvatarDoctor.jpeg';
            $imagenPath = 'public/' . $avatar;
        }*/
        // dd($request);
        $personal = new Personal();
        $personal->ci = $request->ci;
        $personal->nombre = $request->nombre;
        $personal->telefono = $request->telefono;
        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('public/imagenesPersonal');
            $personal->imagen_path = $imagenPath;
        }
        $personal->sexo = $request->sexo;
        $personal->baja = false;
        $personal->estado = false;
        $personal->sueldo = $request->sueldo;
        
        $especialidad = Especialidad::where('descripcion', $request->especialidad)->first();

        if(!$especialidad){
            $especialidad = new Especialidad();
            $especialidad->descripcion = $request->especialidad;
            $especialidad->save();
        }
        
        $personal->id_especialidad = $especialidad->id; 
        $personal->save();
        return redirect()->route('Personal.index');
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
        $personal = Personal::findOrFail($id);
        $especialidades = Especialidad::all();
        return view('VistaPersonal.edit', compact('personal', 'especialidades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    // Validar los datos del formulario si es necesario

    // Obtener el registro existente de Personal que deseas actualizar
    $personal = Personal::findOrFail($id);

    // Actualizar los campos con los datos del formulario
    $personal->ci = $request->ci;
    $personal->nombre = $request->nombre;
    $personal->telefono = $request->telefono;
    $personal->sexo = $request->sexo;
    $personal->sueldo = $request->sueldo;

    // Actualizar la especialidad (similar a cómo lo hiciste en el controlador de store)
    $especialidad = Especialidad::where('descripcion', $request->especialidad)->first();
    if (!$especialidad) {
        $especialidad = new Especialidad();
        $especialidad->descripcion = $request->especialidad;
        $especialidad->save();
    }
    $personal->id_especialidad = $especialidad->id;

    // Actualizar la imagen si se proporciona una nueva
    if ($request->hasFile('imagen')) {
        $imagenPath = $request->file('imagen')->store('public/imagenesPersonal');
        $personal->imagen_path = $imagenPath;
    }

    // Guardar los cambios en la base de datos
    $personal->save();
    $personals = Personal::all();
    // Redirigir a la vista de detalles o a donde desees después de la actualización
    return redirect()->route('Personal.index', compact('personals'));
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $personal = Personal::findOrFail($id); // Encuentra el personal por su ID o lanza una excepción si no existe
            $personal->delete(); // Elimina el registro del personal

            return redirect()->route('Personal.index')->with('success', 'Personal eliminado correctamente');
        } catch (\Exception $e) {
            return redirect()->route('Personal.index')->with('error', 'No se pudo eliminar el personal');
        }
    }

    public function buscarPersonal(Request $request){
        $texto = $request->input('texto');
        $ordenarPor = $request->input('ordenar', 'id');
        $especialidades = Especialidad::all();
    switch ($ordenarPor) {
        case 'salario-desc':
            $personals = Personal::where('nombre', 'LIKE', "%$texto%")->orderBy('sueldo', 'desc')->get();
            break;
        case 'salario-asc':
            $personals = Personal::where('nombre', 'LIKE', "%$texto%")->orderBy('sueldo', 'asc')->get();
            break;
        case 'especialidad':
            $personals = Personal::where('nombre', 'LIKE', "%$texto%")->orderBy('id_especialidad')->get();
            break;
        case 'turno':
            $personals = Personal::where('nombre', 'LIKE', "%$texto%")->orderBy('turno')->get();
            break;
        default:
        $personals = Personal::where(function ($query) use ($texto) {
            $query->where('nombre', 'LIKE', "%$texto%")
                  ->orWhereHas('especialidades', function ($query) use ($texto) {
                      $query->where('descripcion', 'LIKE', "%$texto%");
                  });
        })
        ->orderBy('id')
        ->get();
        
            break;
    }

    return view('_resultadoPersonal', compact('personals'));
    }

    public function baja($id){
        //dd($id);
        $personal = Personal::findOrFail($id);
        $personal->baja = !$personal->baja;
        $personal->save();
        $personals = Personal::all();
        return redirect()->route('Personal.index', compact('personals'));
    }
    
}
