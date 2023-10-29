@extends('Panza')

@section('Panza')

<div class="container mx-auto px-4 py-8">
       
        <div class="mb-4">
            <a href="{{ route('Servicio.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                Crear Nuevo Servicio
            </a>
        </div>
        
        
        <div class="mb-4">
    
</div>
        
        

        
        <table id="tabla-servicios" class="table-auto w-full">
            <thead>
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Descripcion</th>
                    <th class="px-4 py-2">Precio</th>
                    <th class="px-4 py-2">Acciones</th>

                </tr>
            </thead>
            <tbody>
                @include('_resultadosServicios')
            </tbody>
        </table>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
        const buscar = document.getElementById('buscar');
        const tablaServicios = document.getElementById('tabla-servicios');

    function cargarTabla(texto) {
        fetch(`/buscar-servicios?texto=${texto}`)
            .then(response => response.text())
            .then(data => {
                tablaServicios.querySelector('tbody').innerHTML = data;
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
