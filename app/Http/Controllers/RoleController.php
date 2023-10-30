<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permisos = Permission::all();
        return view('VistaRole.create', compact('permisos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles',
            'permissions' => 'array',
        ]);
        $role = Role::create(['name' => $request->name]);

        if ($request->permissions) {
            $role->givePermissionTo($request->permissions);
        }

        activity()
                ->causedBy(auth()->user())//usuario responsable de actividad
                ->log('Creo un nuevo Rol: '. $role->nombre);

        return redirect()->route('Usuario.index');
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
        $role = Role::findOrFail($id);
        return view('VistaRole.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'array',
        ]);

        $role->name = $request->name;
        $role->save();

        if ($request->permissions) {
            $role->syncPermissions($request->permissions);
        } else {
            $role->syncPermissions([]); // Si no se seleccionan permisos, elimina todos los permisos asociados.
        }

        activity()
                ->causedBy(auth()->user())//usuario responsable de actividad
                ->log('Actualizo el Rol: '. $role->nombre);

        return redirect()->route('Usuario.index')
            ->with('success', 'Rol actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findById($id);

        if (!$role) {
            return redirect()->route('Usuario.index')
                ->with('error', 'El rol no existe.');
        }
        if ($role->users->count() > 0) {
            return redirect()->route('Usuario.index')
                ->with('error', 'No puedes eliminar un rol con usuarios asignados.');
        }

        activity()
                ->causedBy(auth()->user())//usuario responsable de actividad
                ->log('Elimino el Rol: '. $role->nombre);

        $role->delete();

        return redirect()->route('Usuario.index')
            ->with('success', 'El rol se ha eliminado correctamente.');
    }
}
