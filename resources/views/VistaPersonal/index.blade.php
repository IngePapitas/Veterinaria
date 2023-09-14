@extends('Panza')

@section('Panza')
<div class="container mx-auto px-4 py-8">

    <div class="mb-4">
        <a href="{{ route('Personal.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
            Registrar Personal
        </a>
    </div>

    <div class="mb-4">
        <label for="ordenar" class="block text-gray-700">Ordenar por:</label>
        <select id="ordenar" class="form-select mt-1 block w-full">
            <option value="id">ID (por defecto)</option>
            <option value="salario-desc">Salario Mayor a menor</option> 
            <option value="salario-asc">Salario Menor a mayor</option>
            <option value="turno">Turno</option>
            <option value="especialidad">Especialidad</option>
        </select>
    </div>


    <table id="tabla-muestra" class="table-auto w-full">
        <thead>
            <tr>
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Imagen</th>
                <th class="px-4 py-2">Nombre</th>
                <!-- <th class="px-4 py-2">Descripción</th> -->
                <th class="px-4 py-2">Especialidad</th>
                <th class="px-4 py-2">Salario</th>
                <th class="px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @include('_resultadosProductos')
        </tbody>
    </table>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const buscar = document.getElementById('buscar');
        const ordenar = document.getElementById('ordenar');
        const tablaCargar = document.getElementById('tabla-muestra');

        function cargarTabla(texto, orden) {
            fetch(`/buscar-personal?texto=${texto}&ordenar=${orden}`)
                .then(response => response.text())
                .then(data => {
                    tablaCargar.querySelector('tbody').innerHTML = data;
                })
                .catch(error => {
                    console.error('Error al cargar los resultados:', error);
                });
        }

        buscar.addEventListener('input', () => {
            const texto = buscar.value.trim().toLowerCase();
            const ordenSeleccionado = ordenar.value;

            if (texto === '') {
                cargarTabla('', ordenSeleccionado);
            } else {
                cargarTabla(texto, ordenSeleccionado);
            }
        });

        ordenar.addEventListener('change', () => {

            const textoBusqueda = buscar.value.trim().toLowerCase();
            const ordenSeleccionado = ordenar.value;

            cargarTabla(textoBusqueda, ordenSeleccionado);
        });
    });
</script>


@endsection