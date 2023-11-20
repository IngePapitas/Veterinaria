@extends('Panza')

@section('Panza')

<div class="container mx-auto px-4 py-8">
    
    <div class="mb-4">
        <a href="{{ route('Cita.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
            Crear Nueva Cita
        </a>
    </div>

    <div class="mb-4 p-4 rounded-2xl bg-gray-300  grid grid-cols-3 gap-2">
        <select id="personalSelect" class="p-2 border rounded">
            <option value="" disabled selected>Personal..</option>
            <option value="">Todos los doctores</option>
            @foreach ($personals as $personal)
            <option value="{{ $personal->id }}">{{ $personal->nombre }}</option>
            @endforeach
        </select>

        <select id="pacienteSelect" class="p-2 border rounded">
            <option value="" disabled selected>Paciente..</option>
            <option value="">Todos los pacientes</option>
            @foreach ($pacientes as $paciente)
            <option value="{{ $paciente->id }}">{{ $paciente->nombre }}</option>
            @endforeach
        </select>

        <button class="bg-blue-500 text-white p-2 rounded" id="btnFiltro">Generar</button>
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
        const btnFiltro = document.getElementById('btnFiltro');
        

        function cargarCitas(personal, paciente) {
            fetch(`/buscar-citas?personal=${personal}&paciente=${paciente}`)
                .then(response => response.text())
                .then(data => {
                    tablaClientes.querySelector('tbody').innerHTML = data;
                })
                .catch(error => {
                    console.error('Error al cargar los resultados:', error);
                });
        }

        btnFiltro.addEventListener('click', () => {
            const personal = document.getElementById('personalSelect').value;
            const paciente = document.getElementById('pacienteSelect').value;

            cargarCitas(personal,paciente);
        });
    });
</script>


@endsection