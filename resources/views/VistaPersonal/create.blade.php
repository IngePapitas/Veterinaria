@extends('Panza')

@section('Panza')
<form action="{{ route('Personal.store') }}" method="POST" class="flex mt-4 overflow-hidden" enctype="multipart/form-data">
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
            <label for="ci" class="block text-gray-700 text-sm font-bold mb-2">CI:</label>
            <input type="text" name="ci" id="ci" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="mb-4">
            <label for="nombre" class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
            <input type="text" name="nombre" id="nombre" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Sexo:</label>
            <div class="mt-2">
                <label class="inline-flex items-center">
                    <input type="radio" name="sexo" value="Hombre" class="form-radio" checked required>
                    <span class="ml-2">Hombre</span>
                </label>
                <label class="inline-flex items-center ml-6">
                    <input type="radio" name="sexo" value="Mujer" class="form-radio" required>
                    <span class="ml-2">Mujer</span>
                </label>
            </div>
        </div>

        <div class="mb-4">
            <label for="telefono" class="block text-gray-700 text-sm font-bold mb-2">Teléfono:</label>
            <input type="text" name="telefono" id="telefono" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="mb-4">
            <label for="sueldo" class="block text-gray-700 text-sm font-bold mb-2">Sueldo:</label>
            <input type="number" name="sueldo" id="sueldo" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="mb-4">
            <label for="especialidad" class="block text-gray-700 text-sm font-bold mb-2">Especialidad:</label>
            <div class="mr-4 flex items-center relative">
                <input type="text" name="especialidad" id="especialidad" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <div id="tablaDiv" class="absolute top-full left-0 bg-yellow-100 hidden">
                    <table id="tabla-especialidades" class="table-auto w-full">
                        <tbody>
                            @include('_resultadoEspecialidades_PersonalCreate')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mb-4">
            <label for="mostrarDiv">Crear usuario?</label>
            <input type="checkbox" id="mostrarDiv" name="usuario">
        </div>

        <div id="miDiv" style="display: none;">
            <label for="correo" class="block text-gray-700 font-bold">Correo:</label>
            <input type="email" id="correo" name="correo" class="w-full border rounded-md py-2 px-3 mt-1 mb-3 focus:outline-none focus:ring focus:border-blue-300" placeholder="Correo">

            <div class="mb-4">
                <label for="rol" class="block text-gray-700 text-sm font-bold mb-2">Rol:</label>
                <select name="rol" id="rol" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <option disabled selected>Seleccione..</option>    
                @foreach($roles as $rol)
                    <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                    @endforeach
                </select>
            </div>

            <label for="password" class="block text-gray-700 font-bold">Contraseña:</label>
            <input type="password" id="password" name="password" class="w-full border rounded-md py-2 px-3 mt-1 mb-5 focus:outline-none focus:ring focus:border-blue-300" placeholder="Contraseña">
        </div>
        <input type="hidden" name="imagenCargadaInput" id="imagenCargadaInput" value="0">

        <div class="mb-4">
            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded focus:outline-none focus:ring focus:border-blue-300">
                Guardar
            </button>
        </div>

    </div>


</form>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const especialidad = document.getElementById('especialidad');
        const tablaDiv = document.getElementById('tablaDiv');
        const tablaEspecialidades = document.getElementById('tabla-especialidades');
        const avatarContainer = document.getElementById('avatar-container');
        const radioButtons = document.querySelectorAll('input[name="sexo"]');
        const cargarImagenInput = document.getElementById('cargarImagen');
        const checkbox = document.getElementById('mostrarDiv');
        let imagenCargada = false;


        const avatarUrl = "{{ asset('storage/AvataresDoctor/AvatarDoctor.jpeg') }}";
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

        tablaEspecialidades.addEventListener('click', (event) => {
            if (event.target.tagName === 'BUTTON') {
                const especialidadValue = event.target.value;
                console.log('Valor del botón de especialidad:', especialidadValue);
                const especialidadInput = document.getElementById('especialidad');
                especialidadInput.value = especialidadValue;
                tablaDiv.classList.add('hidden');
                //5 FUCKING HORAS PARA DESARROLLAR ESTA PUTISIMA FUNCION
            }

        });
        //actualizarAvatar();
        console.log("Avatar ACtualizado");

        function actualizarAvatar() {
            console.log("Avatar ACtualizado");
            const sexoSeleccionado = document.querySelector('input[name="sexo"]:checked').value;
            if (!imagenCargada) {
                if (sexoSeleccionado == 'Mujer') {
                    const avatarUrl = "{{ asset('storage/AvataresDoctor/AvatarMujer.jpeg') }}";
                    console.log(avatarUrl);
                    avatarContainer.style.backgroundImage = `url('${avatarUrl}')`;
                    avatarContainer.style.backgroundSize = '100% 100%';
                } else {
                    const avatarUrl = "{{ asset('storage/AvataresDoctor/AvatarDoctor.jpeg') }}";
                    console.log(avatarUrl);
                    avatarContainer.style.backgroundImage = `url('${avatarUrl}')`;
                    avatarContainer.style.backgroundSize = '100% 100%';
                }
            }

        }

        eliminarImagenBtn.addEventListener('click', () => {
            cargarImagenInput.value = ''; // Borrar la selección de imagen
            eliminarImagenBtn.classList.add('hidden'); // Ocultar el botón de eliminación
            imagenCargada = false; // Marcar que no hay imagen cargada
            actualizarAvatar();
        });


        radioButtons.forEach(radioButton => {
            radioButton.addEventListener('change', actualizarAvatar);
        });

        checkbox.addEventListener('change', function() {
            if (this.checked) {
                miDiv.style.display = 'block';
            } else {
                miDiv.style.display = 'none';
            }
        });
    });
</script>
@endsection