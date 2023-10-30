<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personal;
use App\Models\Especialidad;
use Spatie\Permission\Models\Role;

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
        $roles = Role::all();
        return view('VistaPersonal.create', compact('especialidades','roles'));
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

        activity()
        ->causedBy(auth()->user())//usuario responsable de actividad
        ->log('Registro al nuevo personal: '. $personal->nombre);

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

        activity()
            ->causedBy(auth()->user())//usuario responsable de actividad
            ->log('Actualizo la especialidad del personal: '. $personal->nombre);

        $especialidad->save();
    }
    $personal->id_especialidad = $especialidad->id;

    // Actualizar la imagen si se proporciona una nueva
    if ($request->hasFile('imagen')) {
        $imagenPath = $request->file('imagen')->store('public/imagenesPersonal');
        $personal->imagen_path = $imagenPath;
    }else{
        if($request->imagen_cargada == 0){
            $personal->imagen_path = null;
        }
        
    }

    // Guardar los cambios en la base de datos
    $personal->save();

    activity()
        ->causedBy(auth()->user())//usuario responsable de actividad
        ->log('Actualizo datos del personal: '. $personal->nombre);

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

            activity()
                ->causedBy(auth()->user())//usuario responsable de actividad
                ->log('Elimino al personal: '. $personal->nombre);

            $personal->delete(); // Elimina el registro del personal

            return redirect()->route('Personal.index')->with('success', 'Personal eliminado correctamente');
        } catch (\Exception $e) {
            return redirect()->route('Personal.index')->with('error', 'No se pudo eliminar el personal');
        }
    }

    public function buscarPersonal(Request $request){
        $texto = $request->input('texto');
        $ordenarPor = $request->input('ordenar', 'id');
        $personals = Personal::select('personals.*')
        ->join('especialidads', 'personals.id_especialidad', '=', 'especialidads.id')
        ->where(function ($query) use ($texto) {
            $query->where('personals.nombre', 'LIKE', "%$texto%")
                ->orWhere('especialidads.descripcion', 'LIKE', "%$texto%");
        })
        ->orderBy($ordenarPor === 'salario-desc' ? 'sueldo' : 'id', $ordenarPor === 'salario-asc' ? 'asc' : 'desc')
        ->get();
    

    return view('_resultadoPersonal', compact('personals'));
    }

    public function baja($id){
        //dd($id);
        $personal = Personal::findOrFail($id);
        $personal->baja = !$personal->baja;

        if($personal->baja){
            activity()
                ->causedBy(auth()->user())//usuario responsable de actividad
                ->log('Se dio inactividad al personal: '. $personal->nombre);
        }else{
            activity()
                ->causedBy(auth()->user())//usuario responsable de actividad
                ->log('Se volvio activo al personal: '. $personal->nombre);
        }

        $personal->save();
        $personals = Personal::all();
        return redirect()->route('Personal.index', compact('personals'));
    }
    
}
