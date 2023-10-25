@extends('Panza')

@section('Panza')

<div class="container mx-auto px-4 py-8">
        @can('Crear Cliente')
        <div class="mb-4">
            <a href="{{ route('Cliente.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                Crear Nuevo Cliente
            </a>
        </div>
        @endcan
        
        <div class="mb-4">
    
</div>
        
        <div class="mb-4">
            <label for="buscar" class="block text-gray-700">Buscar por nombre:</label>
            <input type="text" id="buscar" class="form-input mt-1 block w-full" placeholder="Escribe para buscar...">
        </div>

        
        <table id="tabla-clientes" class="table-auto w-full">
            <thead>
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">CI</th>
                    <th class="px-4 py-2">Nombre</th>
                    <!-- <th class="px-4 py-2">Descripción</th> -->
                    <th class="px-4 py-2">Telefono</th>
                    <th class="px-4 py-2">Correo</th>
                    @can('Editar Cliente')
                    <th class="px-4 py-2">Acciones</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @include('_resultadosClientes')
            </tbody>
        </table>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
        const buscar = document.getElementById('buscar');
        const tablaClientes = document.getElementById('tabla-clientes');

    function cargarClientes(texto) {
        fetch(`/buscar-clientes?texto=${texto}`)
            .then(response => response.text())
            .then(data => {
                tablaClientes.querySelector('tbody').innerHTML = data;
            })
            .catch(error => {
                console.error('Error al cargar los resultados:', error);
            });
    }

    buscar.addEventListener('input', () => {
        const texto = buscar.value.trim().toLowerCase();

        if (texto === '') {
            cargarClientes('');
        } else {
            cargarClientes(texto);
        }
    });
});
    </script>

    
@endsection
