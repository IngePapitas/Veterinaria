@extends('Panza')

@section('Panza')
<form action="{{ route('Personal.store') }}" method="POST" class="flex mt-4 overflow-hidden">
    @csrf
    <div class="w-1/4 h-screen bg-gray-200">
        <div class="w-full bg-blue-300 flex" style="padding-bottom: 100%;">
            <div class="h-full w-full bg-red-500 ">

            </div>
        </div>
    </div>
    <div class="w-3/4 h-screen bg-blue-200">

        <div class="mb-4">
            <label for="ci" class="block text-gray-700 text-sm font-bold mb-2">CI:</label>
            <input type="text" name="ci" id="ci" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-4">
            <label for="nombre" class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
            <input type="text" name="nombre" id="nombre" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-4">
            <label for="telefono" class="block text-gray-700 text-sm font-bold mb-2">Teléfono:</label>
            <input type="text" name="telefono" id="telefono" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-4">
            <label for="sueldo" class="block text-gray-700 text-sm font-bold mb-2">Sueldo:</label>
            <input type="number" name="sueldo" id="sueldo" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-4">
            <label for="especialidad" class="block text-gray-700 text-sm font-bold mb-2">Especialidad:</label>
            <input type="text" name="especialidad" id="especialidad" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <div id="tablaDiv" class="absolute top-full left-0 bg-gray-200 hidden">
                <table id="tabla-especialidades" class="table-auto w-full">
                    <tbody>
                        @include('_resultadoEspecialidades_PersonalCreate')
                    </tbody>
                </table>
            </div>
        </div>


        <div class="mb-4">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Guardar
            </button>
        </div>
</form>
</div>

</form>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const especialidad = document.getElementById('especialidad');
        const tablaDiv = document.getElementById('tablaDiv');
        const tablaEspecialidades = document.getElementById('tabla-especialidades');
        const buttonEspecialidad = document.getElementById('buttonEspecialidad');

        especialidad.addEventListener('input', () => {
            const texto = especialidad.value.trim().toLowerCase();
            const tituloDiv = document.getElementById('titulo');
            if (texto === '') {
                tablaDiv.classList.add('hidden');
                cargarEspecialidades('');
            } else {
                tablaDiv.classList.remove('hidden');
                cargarEspecialidades(texto);
            }
        });

        function cargarEspecialidades(texto) {
            fetch(`/buscar-especialidades-create?texto=${texto}`)
                .then(response => response.text())
                .then(data => {
                    tablaEspecialidades.querySelector('tbody').innerHTML = data;
                })
                .catch(error => {
                    console.error('Error al cargar los resultados:', error);
                });
        }

        

    });
    document.querySelectorAll('[id^="buttonEspecialidad"]').forEach(button => {
    button.addEventListener('click', (event) => {
        const especialidadValue = event.target.value;
        // Ahora puedes hacer lo que quieras con especialidadValue
        console.log('Valor del botón de especialidad:', especialidadValue);
        // Asignar el valor al input de especialidad
        especialidad.value = especialidadValue;
    });
});

</script>
@endsection