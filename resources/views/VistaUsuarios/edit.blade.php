@extends('Panza')

@section('Panza')
<form action="{{ route('Usuario.update', $usuario->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div id="registro-form" class="flex mt-4 overflow-hidden">
        <div class="w-1/4 h-auto bg-gray-200">
            <div class="w-full bg-blue-300 flex items-center justify-center" id="avatar-container" style="padding-bottom: 100%;">
                <button id="eliminarImagenBtn" type="button" class="hidden bg-red-500 text-white font-semibold py-1 px-2 rounded">
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
            <!-- Formulario de edición -->

            <div class="mb-4">
                <label for="nombre" class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
                <input type="text" name="name" id="name" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required value="{{ $usuario->name }}">
            </div>

            

            
                <label for="correo" class="block text-gray-700 font-bold">Correo:</label>
                <input type="email" id="correo" name="correo" class="w-full border rounded-md py-2 px-3 mt-1 mb-3 focus:outline-none focus:ring focus:border-blue-300" placeholder="Correo" value="{{ $usuario->email }}">


                <div class="mb-4">
                    <label for="rol" class="block text-gray-700 text-sm font-bold mb-2">Rol:</label>
                    <select name="rol" id="rol" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        @foreach($roles as $rol)
                        <option value="{{ $rol->id }}" {{ $usuario->id_rol == $rol->id ? 'selected' : '' }}>{{ $rol->name }}</option>
                        @endforeach
                    </select>
                </div>


                <label for="password" class="block text-gray-700 font-bold">Contraseña:</label>
                <input type="password" id="password" name="password" class="w-full border rounded-md py-2 px-3 mt-1 mb-5 focus:outline-none focus:ring focus:border-blue-300" placeholder="Contraseña">
            
            <input type="hidden" name="imagenCargadaInput" id="imagenCargadaInput" value="0">
            <button id="registro-btn" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded focus:outline-none focus:ring focus:border-blue-300">Actualizar</button>


            <!-- Fin del formulario de edición -->
        </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        const avatarContainer = document.getElementById('avatar-container');
        
        const cargarImagenInput = document.getElementById('cargarImagen');


        let imagenCargada = false;
        actualizarAvatar();

        cargarImagenInput.addEventListener('change', (event) => {
            const imagenSeleccionada = event.target.files[0];
            if (imagenSeleccionada) {
                const imageUrl = URL.createObjectURL(imagenSeleccionada);
                avatarContainer.style.backgroundImage = `url('${imageUrl}')`;
                imagenCargada = true;
                document.getElementById('imagenCargadaInput').value = 1;
                eliminarImagenBtn.classList.remove('hidden');
            }
        });

        function actualizarAvatar() {
            console.log("Avatar ACtualizado");
    
            if (!imagenCargada) {
                console.log("entro");
                
                    const avatarUrl = "{{ asset('storage/Avatares/Hombre.jpg') }}";
                    console.log(avatarUrl);
                    avatarContainer.style.backgroundImage = `url('${avatarUrl}')`;
                    avatarContainer.style.backgroundSize = '100% 100%';
                
            }
        }
        verificarAvatar();

        function verificarAvatar() {
            const imagenPath = "{{ Storage::url($usuario->imagen_path) }}"; // Obtener la URL de la imagen desde Laravel
            console.log(imagenPath);
            if (imagenPath != "/storage/") {
                avatarContainer.style.backgroundImage = `url('${imagenPath}')`; // Establecer la imagen como fondo
                imagenCargada = true;
                document.getElementById('imagenCargadaInput').value = 1;
                eliminarImagenBtn.classList.remove('hidden');
            } else {
                actualizarAvatar();
            }
        }

        eliminarImagenBtn.addEventListener('click', () => {
            cargarImagenInput.value = '';
            eliminarImagenBtn.classList.add('hidden');
            document.getElementById('imagenCargadaInput').value = 0;
            imagenCargada = false;
            actualizarAvatar();
        });

        
    });
</script>
</div>
@endsection