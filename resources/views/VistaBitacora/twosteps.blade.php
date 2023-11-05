@extends('Panza')

@section('Panza')
<div class=" w-full h-screen flex text-center items-center justify-center">
    <span class="text-red-500 text-sm font-bold m-8 hidden" id="donthavepermissions">No tienes permisos suficientes para estar aqui!</span>
    <div class="w-1/2 hidden" id="formVerificar">
        <span class="text-red-500 text-sm font-bold m-8 hidden" id="wrongpass">Contraseña incorrecta</span>
        <label for="contasena" class="block text-gray-700 text-sm font-bold mb-2">Ingrese su contraseña:</label>
        <input type="password" name="contasena" id="contrasena" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        <button type="button" id="btnContrasena" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 mt-4 px-8 rounded text-base">
            Listo
        </button>

        
    </div>
    <form action="{{ route('Bitacora.verificarClaveUnica') }}" method="POST" id="formClave" class="hidden">
            @csrf
            <input type="hidden" name="claveInput" id="claveInput" >
            <label for="clave" class="block text-gray-700 text-sm font-bold mb-2">Ingrese la clave:</label>
            <input type="password" name="clave" id="clave" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 mt-4 px-8 rounded text-base">
                Listo
            </button>
        </form>


</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const usuario = @json($usuario);
        const rol = @json($rol);
        const donthavepermissions = document.getElementById('donthavepermissions');
        const formVerificar = document.getElementById('formVerificar');
        const btnContrasena = document.getElementById('btnContrasena');
        const wrongpass = document.getElementById('wrongpass');
        const contrasena = document.getElementById('contrasena');
        const formClave = document.getElementById('formClave');
        const claveInput = document.getElementById('claveInput');

        console.log(usuario);
        console.log(rol);

        verificarAdministrador();

        function verificarAdministrador() {
            if (rol.name != 'Admin') {
                donthavepermissions.classList.remove('hidden');
            } else {
                formVerificar.classList.remove('hidden');
            }
        }

        btnContrasena.addEventListener('click', () => {
            console.log(usuario);
            fetch(`/verificar-contrasena?usuario=${usuario.id}&texto=${contrasena.value}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data === true) {
                        mandarCorreo(usuario);
                    } else {

                        wrongpass.classList.remove('hidden');
                        setTimeout(() => {
                            wrongpass.classList.add('hidden');
                        }, 2000);
                    }
                })
                .catch(error => {
                    console.error('Error al cargar los resultados:', error);
                });

        });

        function mandarCorreo($usuario) {
            fetch(`/mandar-clave?usuario=${usuario.id}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    claveInput.value = data;
                    formVerificar.classList.add('hidden');
                    formClave.classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error al cargar los resultados:', error);
                });
        }
    });
</script>
@endsection