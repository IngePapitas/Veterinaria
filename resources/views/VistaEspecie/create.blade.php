@extends('Panza')

@section('Panza')
<form action="{{ route('Especie.store') }}" method="POST" class="flex mt-4 overflow-hidden" enctype="multipart/form-data">
    @csrf
    <div class="w-1/4 h-auto bg-gray-200">
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
    <div class="w-3/4 h-auto bg-blue-200 p-16">


        <div class="mb-4">
            <label for="nombre" class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
            <input type="text" name="nombre" id="nombre" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="mb-4">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Guardar
            </button>
        </div>

    </div>


</form>
<script>
    document.addEventListener('DOMContentLoaded', () => {

        const avatarContainer = document.getElementById('avatar-container');
        const cargarImagenInput = document.getElementById('cargarImagen');
        let imagenCargada = false;

        const avatarUrl = "{{ asset('storage/AvataresPacientes/can.jpg') }}";
        console.log(avatarUrl);
        avatarContainer.style.backgroundImage = `url('${avatarUrl}')`;
        avatarContainer.style.backgroundSize = '100% 100%';

        cargarImagenInput.addEventListener('change', (event) => {
            const imagenSeleccionada = event.target.files[0]; // Obtener la imagen seleccionada
            if (imagenSeleccionada) {
                const imageUrl = URL.createObjectURL(imagenSeleccionada); // Crear una URL para la imagen seleccionada
                avatarContainer.style.backgroundImage = `url('${imageUrl}')`; // Establecer la imagen como fondo   
                imagenCargada = true;
                eliminarImagenBtn.classList.remove('hidden');
            }
        });
        console.log("Avatar ACtualizado");

        eliminarImagenBtn.addEventListener('click', () => {
            cargarImagenInput.value = ''; // Borrar la selección de imagen
            eliminarImagenBtn.classList.add('hidden'); // Ocultar el botón de eliminación
            imagenCargada = false;
            avatarContainer.style.backgroundImage = `url('${avatarUrl}')`;
            avatarContainer.style.backgroundSize = '100% 100%'; // Marcar que no hay imagen cargada
        });



    });
</script>
@endsection