<?php

namespace App\Http\Controllers;
use Session;

use App\Models\User;
use App\Models\Personal;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;


class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        $usuarios = User::obtenerUsuarioRol();
        return view('VistaUsuarios.index', compact('usuarios','roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('VistaUsuarios.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            
            $usuario = new User();
            $usuario = User::where('email', $request->email)->first();
            if($usuario){
                toastr()
                        ->closeButton(true)
                        ->addWarning('Email ya registrado.');
                    return response()->json(['error' => true, 'mensaje' => 'Email ya existente']);
            }
                $user = new User();
                $user->name = $request->nombre;
                $user->email = $request->correo;
                $user->password = bcrypt($request->password);
                $rol = Role::where('id', $request->rol)->first();
                $user->assignRole([$rol]);

                if ($request->hasFile('imagen')) {
                    $imagenPath = $request->file('imagen')->store('empleados', 'public');
                    $user->profile_photo_path = $imagenPath; 
                }
                $user->save();

                activity()
                    ->causedBy(auth()->user())//usuario responsable de actividad
                    ->log('Creo un usuario con email: '. $user->correo);

            toastr()->addSuccess('Usuario creado existosamente.');
            return redirect()->route('Usuario.index');
            
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'mensaje' => $e->getMessage()], 500);
        }
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
    public function edit($id)
    {
        $usuario = User::obtenerUsuarioRolId($id);
        $roles = Role::all();
        return view('VistaUsuarios.edit',compact('usuario', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = User::findOrFail($id); 
                $user->name = $request->name;
                $user->email = $request->correo;
                $user->syncRoles([]);
                $rol = Role::where('id', $request->rol)->first();
                $user->assignRole([$rol]);
                if($request->password){
                    $user->password = bcrypt($request->password);
                }
                if ($request->hasFile('imagen')) {
                    $imagenPath = $request->file('imagen')->store('empleados', 'public');
                    $user->profile_photo_path = $imagenPath; 
                }
                if($request->imagenCargadaInput == "0"){
                    $user->profile_photo_path = null; 
                }
                $user->save();

                activity()
                    ->causedBy(auth()->user())//usuario responsable de actividad
                    ->log('Actualizo al usuario con email: '. $user->correo);

            toastr()->addSuccess('Usuario actualizado existosamente.');
            return redirect()->route('Usuario.index');
            
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'mensaje' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
    }
    public function buscarUsuario(Request $request)
    {
        $texto = $request->input('texto');
        
        $usuarios = User::buscarLike($texto);

        return view('_resultadoUsuario', compact('usuarios'));
    }
}
