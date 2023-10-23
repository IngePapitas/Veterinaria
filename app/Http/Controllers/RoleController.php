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
        return view('VistaRole.create',compact('permisos'));
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

    return redirect()->route('Usuario.index')
        ->with('success', 'Rol actualizado exitosamente');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
