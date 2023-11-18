@extends('Panza')

@section('Panza')

<div class="container mx-auto px-4 py-8">
    
    <div class="mb-4">
        <a href="{{ route('Cita.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
            Crear Nueva Cita
        </a>
    </div>
    

    <div class="mb-4">

    </div>

    <table id="tabla-clientes" class="table-auto w-full">
        <thead>
            <tr>
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Paciente</th>
                <th class="px-4 py-2">Asignado</th>
                <th class="px-4 py-2">Fecha</th>
                <th class="px-4 py-2">Hora</th>
                <th class="px-4 py-2">Estado</th>
                <th class="px-4 py-2">Acciones</th>

            </tr>
        </thead>
        <tbody>
            @include('_resultadosCitas')
        </tbody>
    </table>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const buscar = document.getElementById('buscar');
        const tablaClientes = document.getElementById('tabla-clientes');

        function cargarClientes(texto) {
            fetch(`/buscar-citas?texto=${texto}`)
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