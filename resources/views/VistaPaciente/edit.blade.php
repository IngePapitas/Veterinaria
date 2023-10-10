@extends('Panza')

@section('Panza')
<form action="{{ route('Paciente.update', $paciente->id) }}" method="POST" class="flex mt-4 overflow-hidden" enctype="multipart/form-data">
    @csrf
    @method('PUT') <!-- Usamos el método PUT para actualizar el recurso -->

    <div class="w-1/4 h-screen bg-gray-200">
        <div class="w-full bg-blue-300 flex items-center justify-center" id="avatar-container" style="padding-bottom: 100%;">
            <button id="eliminarImagenBtn" type="button" class="hidden  bg-red-500 text-white font-semibold py-1 px-2 rounded">
                Eliminar Imagen
            </button>
        </div>
        <div class="mb-4 flex items-center justify-center my-4">
            <input type="file" name="imagen" id="cargarImagen" accept="image/*" class="hidden">
            <label for="cargarImagen" class="cursor-pointer bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Cargar imagen
            </label>
        </div>
    </div>

    <div class="w-3/4 h-screen bg-blue-200 p-16">
        <div class="mb-4">
            <label for="nombre" class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
            <input type="text" name="nombre" id="nombre" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="mb-4">
            <label for="peso" class="block text-gray-700 text-sm font-bold mb-2">Peso(Kg):</label>
            <input type="text" name="peso" id="peso" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="mb-4">
            <label for="tamano" class="block text-gray-700 text-sm font-bold mb-2">Tamaño(cm):</label>
            <input type="text" name="tamano" id="tamano" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="mb-4">
            <label for="especie" class="block text-gray-700 text-sm font-bold mb-2">Especie:</label>
            <div class="mr-4 flex items-center relative">
                <input type="text" name="especie" id="especie" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <div id="tablaEspeciesDiv" class="absolute top-full left-0 bg-yellow-100 hidden">
                    <table id="tabla-especies" class="table-auto w-full">
                        <tbody>
                            @include('_resultadoEspecie_PacienteCreate')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <label for="raza" class="block text-gray-700 text-sm font-bold mb-2">Raza:</label>
            <div class="mr-4 flex items-center relative">
                <input type="text" name="raza" id="raza" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <div id="tablaRazasDiv" class="absolute top-full left-0 bg-yellow-100 hidden">
                    <table id="tabla-razas" class="table-auto w-full">
                        <tbody>
                            @include('_resultadoRaza_PacienteCreate')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Aquí otros campos del formulario -->

        <div class="mb-4">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Guardar
            </button>
        </div>
    </div>
</form>

<script>
    // El JavaScript necesario que tenías en la vista original
</script>
@endsection