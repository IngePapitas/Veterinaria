@extends('Panza')

@section('Panza')
<div class="flex justify-center">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        ROLES
    </h2>
</div>

<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Crear Rol</h1>
    <form method="POST" action="{{ route('Role.store') }}" class="bg-white p-6 rounded-lg shadow-md">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-semibold mb-2">Nombre de Rol:</label>
            <input type="text" name="name" id="name" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <h2 class="text-lg font-semibold mb-2 rounded ">Permisos:</h2>
        <div class="flex flex-wrap">
            <!-- Category 1 -->
            <div class="w-1/3 p-4">
                <h3 class="text-base font-semibold mb-2">Paciente</h3>
                <div class="mb-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="permissions[]" value="Ver Paciente" class="form-checkbox">
                        <span class="ml-2">Ver Paciente</span>
                    </label>
                </div>

                <div class="mb-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="permissions[]" value="Editar Paciente" class="form-checkbox">
                        <span class="ml-2">Editar Paciente</span>
                    </label>
                </div>
                <div class="mb-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="permissions[]" value="Guardar Paciente" class="form-checkbox">
                        <span class="ml-2">Guardar Paciente</span>
                    </label>
                </div>
            </div>

            <!-- Category 2 -->
            <div class="w-1/3 p-4">
                <h3 class="text-base font-semibold mb-2">Personal</h3>
                <div class="mb-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="permissions[]" value="Ver Personal" class="form-checkbox">
                        <span class="ml-2">Ver Personal</span>
                    </label>
                </div>
                <div class="mb-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="permissions[]" value="Crear Personal" class="form-checkbox">
                        <span class="ml-2">Crear Personal</span>
                    </label>
                </div>
                <div class="mb-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="permissions[]" value="Editar Personal" class="form-checkbox">
                        <span class="ml-2">Editar Personal</span>
                    </label>
                </div>
            </div>

            <!-- Category 3 -->
            <div class="w-1/3 p-4">
                <h3 class="text-base font-semibold mb-2">Usuarios</h3>
                <div class="mb-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="permissions[]" value="Ver Usuario" class="form-checkbox">
                        <span class="ml-2">Ver Usuario</span>
                    </label>
                </div>
                <div class="mb-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="permissions[]" value="Crear Usuario" class="form-checkbox">
                        <span class="ml-2">Crear Usuario</span>
                    </label>
                </div>
                <div class="mb-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="permissions[]" value="Editar Usuario" class="form-checkbox">
                        <span class="ml-2">Editar Usuario</span>
                    </label>
                </div>
            </div>

            <!-- Category 4 -->
            <div class="w-1/3 p-4">
                <h3 class="text-base font-semibold mb-2">Especie</h3>
                <div class="mb-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="permissions[]" value="Ver Especie" class="form-checkbox">
                        <span class="ml-2">Ver Especie</span>
                    </label>
                </div>
                <div class="mb-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="permissions[]" value="Crear Especie" class="form-checkbox">
                        <span class="ml-2">Crear Especie</span>
                    </label>
                </div>
                <div class="mb-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="permissions[]" value="Editar Especie" class="form-checkbox">
                        <span class="ml-2">Editar Especie</span>
                    </label>
                </div>
            </div>

            <!-- Category 5 -->
            <div class="w-1/3 p-4">
                <h3 class="text-base font-semibold mb-2">Medicamento</h3>
                <div class="mb-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="permissions[]" value="Ver Medicamento" class="form-checkbox">
                        <span class="ml-2">Ver Medicamento</span>
                    </label>
                </div>
                <div class="mb-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="permissions[]" value="Crear Medicamento" class="form-checkbox">
                        <span class="ml-2">Crear Medicamento</span>
                    </label>
                </div>
                <div class="mb-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="permissions[]" value="Editar Medicamento" class="form-checkbox">
                        <span class="ml-2">Editar Medicamento</span>
                    </label>
                </div>
            </div>

            

        <div class="mt-6">
            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded focus:outline-none focus:ring focus:border-blue-300">Crear Rol</button>
        </div>
    </form>
</div>
@endsection