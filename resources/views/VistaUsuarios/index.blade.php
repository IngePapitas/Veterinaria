@extends('Panza')


@section('Panza')
<div class="container mx-auto px-4 py-8">
    
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
        USUARIOS
    </h2>
    @can('Crear Usuario')
    <div class="mb-4">
        <a href="{{ route('Usuario.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
            Crear Nuevo Usuario
        </a>
    </div>
    @endcan


    <div class="mb-4">
        <label for="buscar" class="block text-gray-700">Buscar por nombre:</label>
        <input type="text" id="buscar" class="form-input mt-1 block w-full" placeholder="Escribe para buscar...">
    </div>


    <table id="tabla-usuario" class="table-auto w-full">
        <thead>
            <tr>
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Foto</th>
                <th class="px-4 py-2">Nombre</th>
                <th class="px-4 py-2">Email</th>
                @can('Editar Usuario')
                <th class="px-4 py-2">Acciones</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @include('_resultadoUsuario')
        </tbody>
    </table>



</div>
<div class="container mx-auto px-4 py-8">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
        ROLES
    </h2>
    <div class="mb-4">
        <a href="{{ route('Role.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
            Crear Nuevo Rol
        </a>
    </div>
    <table id="tabla-roles" class="table-auto w-full">
        <thead>
            <tr>
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Nombre</th>
                <th class="px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @include('_resultadoRoles')
        </tbody>
    </table>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const buscar = document.getElementById('buscar');
        const tablallenar = document.getElementById('tabla-usuario');

        function cargarTabla(texto) {
            fetch(`/buscar-usuario?texto=${texto}`)
                .then(response => response.text())
                .then(data => {
                    tablallenar.querySelector('tbody').innerHTML = data;
                })
                .catch(error => {
                    console.error('Error al cargar los resultados:', error);
                });
        }

        buscar.addEventListener('input', () => {
            const texto = buscar.value.trim().toLowerCase();

            if (texto === '') {
                cargarTabla('');
            } else {
                cargarTabla(texto);
            }
        });
    });
</script>


@endsection