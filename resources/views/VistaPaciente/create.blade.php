@extends('Panza')

@section('Panza')
<form action="{{ route('Paciente.store') }}" method="POST" class="flex mt-4 overflow-hidden" enctype="multipart/form-data">
    @csrf
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



        <div class="mb-4">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Guardar
            </button>
        </div>

    </div>


</form>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const raza = document.getElementById('raza');
        const especie = document.getElementById('especie');
        const tablaEspeciesDiv = document.getElementById('tablaEspeciesDiv');
        const tablaRazaDiv = document.getElementById('tablaRazasDiv');
        const tablaEspecies = document.getElementById('tabla-especies');
        const tablaRaza = document.getElementById('tabla-razas');
        const avatarContainer = document.getElementById('avatar-container');
        const cargarImagenInput = document.getElementById('cargarImagen');
        let imagenCargada = false;

        actualizarAvatar();


        cargarImagenInput.addEventListener('change', (event) => {
            const imagenSeleccionada = event.target.files[0]; // Obtener la imagen seleccionada
            if (imagenSeleccionada) {
                const imageUrl = URL.createObjectURL(imagenSeleccionada); // Crear una URL para la imagen seleccionada
                avatarContainer.style.backgroundImage = `url('${imageUrl}')`; // Establecer la imagen como fondo   
                imagenCargada = true;
                eliminarImagenBtn.classList.remove('hidden');
            }
        });

        especie.addEventListener('input', () => {
            const texto = especie.value.trim().toLowerCase();
            if (texto === '') {
                tablaEspeciesDiv.classList.add('hidden');
                cargarEspecies('');
            } else {
                tablaEspeciesDiv.classList.remove('hidden');
                cargarEspecies(texto);
            }
        });

        function cargarEspecies(texto) {
            fetch(`/buscar-especies-create?texto=${texto}`)
                .then(response => response.text())
                .then(data => {
                    tablaEspecies.querySelector('tbody').innerHTML = data;
                })
                .catch(error => {
                    console.error('Error al cargar los resultados:', error);
                });
        }

        tablaEspecies.addEventListener('click', (event) => {
            if (event.target.tagName === 'BUTTON') {
                const especieValue = event.target.value;
                console.log('Valor del botón de especialidad:', especieValue);
                const especieInput = document.getElementById('especie');
                especieInput.value = especieValue;
                actualizarAvatar();
                tablaEspeciesDiv.classList.add('hidden');
            }

        });

        raza.addEventListener('input', () => {
            const texto = raza.value.trim().toLowerCase();
            if (texto === '') {
                tablaRazaDiv.classList.add('hidden');
                cargarRazas('');
            } else {
                tablaRazaDiv.classList.remove('hidden');
                cargarRazas(texto);
            }
        });

        function cargarRazas(texto) {
            const especietext = especie.value.trim().toLowerCase();
            fetch(`/buscar-razas-create?texto=${texto}&especie=${especietext}`)
                .then(response => response.text())
                .then(data => {
                    tablaRaza.querySelector('tbody').innerHTML = data;
                })
                .catch(error => {
                    console.error('Error al cargar los resultados razas:', error);
                });
        }

        tablaRaza.addEventListener('click', (event) => {
            if (event.target.tagName === 'BUTTON') {
                const razaValue = event.target.value;
                console.log('Valor del botón de especialidad:', razaValue);
                const razaInput = document.getElementById('raza');
                razaInput.value = razaValue;
                tablaRazaDiv.classList.add('hidden');
            }

        });
        //actualizarAvatar();

        console.log("Avatar ACtualizado");

        function actualizarAvatar() {
            console.log("Avatar Actualizado");
            if (!imagenCargada) {
                const texto = especie.value.trim().toLowerCase();
                console.log("enviando a la funcion", texto);
                fetch(`/buscar-especie-imagen?texto=${texto}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log("Valor de imagenUrl:", data.imagenUrl);
                        const imagenUrl = data.imagenUrl;
                        const avatarUrl = `{{ asset('storage/${imagenUrl}') }}`; // Corregido aquí
                        console.log(imagenUrl);
                        avatarContainer.style.backgroundImage = `url('${avatarUrl}')`; // Usamos la variable avatarUrl
                        avatarContainer.style.backgroundSize = '100% 100%';

                    })
                    .catch(error => {
                        console.error('Error al cargar los imagen:', error);
                    });


            }

        }


        eliminarImagenBtn.addEventListener('click', () => {
            cargarImagenInput.value = ''; // Borrar la selección de imagen
            eliminarImagenBtn.classList.add('hidden'); // Ocultar el botón de eliminación
            imagenCargada = false; // Marcar que no hay imagen cargada
            actualizarAvatar();
        });



    });
</script>
@endsection