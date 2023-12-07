<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Vetlink</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <!-- Styles -->
    @livewireStyles
</head>
<div class="flex flex-col h-screen bg-gray-100">

    <!-- Barra de navegación superior -->
    <div class="bg-white text-white shadow w-full p-2 pb-0 flex items-center justify-between">
        <div class="flex items-center">
            <div class="flex items-center"> <!-- Mostrado en todos los dispositivos -->
                <img src="https://www.emprenderconactitud.com/img/POC%20WCS%20(1).png" alt="Logo" class="w-28 h-18 mr-2">
                <h2 class="font-bold text-xl">Nombre de la Aplicación</h2>
            </div>
            <div class="md:hidden flex items-center"> <!-- Se muestra solo en dispositivos pequeños -->
                <button id="menuBtn">
                    <i class="fas fa-bars text-gray-500 text-lg"></i> <!-- Ícono de menú -->
                </button>
            </div>
        </div>

        <!-- Ícono de Notificación y Perfil -->
        <div class="space-x-5">
            <button>
                <i class="fas fa-bell text-gray-500 text-lg"></i>
            </button>
            <!-- Botón de Perfil -->
            <button id="user-menu-button">
                <i class="fas fa-user text-gray-500 text-lg"></i>
                <span class="text-gray-500 hidden md:inline">{{ Auth::user()->name }}</span>
            </button>
            <div id="user-menu-popup" class="hidden absolute right-0 w-36 bg-white rounded-lg shadow-lg z-50">
                <button class="block text-gray-900 py-2.5 px-4 rounded transition duration-200 hover:bg-gradient-to-r hover:from-blue-500 hover:to-blue-700 hover:text-white mt-auto w-full" type="submit">
                    <a href="{{ route('profile.show') }}">Perfil</a>
                </button>
                <!-- Ítem de Cerrar Sesión -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="block text-gray-900 py-2.5 px-4 rounded transition duration-200 hover:bg-gradient-to-r hover:from-blue-500 hover:to-blue-700 hover:text-white mt-auto w-full" type="submit">Cerrar sesión</button>
                </form>                   
            </div>
        </div>
    </div>

    <!-- Contenido principal -->
    <div class="flex-1 flex flex-wrap p-0">
        <!-- Barra lateral de navegación (oculta en dispositivos pequeños) -->
        <div class="p-2 bg-white h-full w-full md:w-60 flex flex-col md:flex hidden" id="sideNav">
            <nav>
                <a class="block text-gray-500 py-1.5 px-4 my-0 rounded transition duration-200 hover:bg-gradient-to-r hover:from-cyan-500 hover:to-cyan-500 hover:text-white" href="{{ route('Dashboard') }}">
                    <i class="fas fa-home mr-2"></i>Inicio
                </a>
                <a class="block text-gray-500 py-1.5 px-4 my-0 rounded transition duration-200 hover:bg-gradient-to-r hover:from-cyan-500 hover:to-cyan-500 hover:text-white" href="{{ route('calendario.index')}}">
                    <i class="fa-solid fa-calendar mr-2"></i>Calendario de eventos
                </a>
                @can('Ver Paciente')
                <a class="block text-gray-500 py-1.5 px-4 my-0 rounded transition duration-200 hover:bg-gradient-to-r hover:from-cyan-500 hover:to-cyan-500 hover:text-white" href="{{ route('Paciente.index')}}">
                    <i class="fa-solid fa-dog mr-2"></i>Pacientes
                </a>
                @endcan
                @can('Ver Personal')
                <a class="block text-gray-500 py-1.5 px-4 my-0 rounded transition duration-200 hover:bg-gradient-to-r hover:from-cyan-500 hover:to-cyan-500 hover:text-white" href="{{ route('Personal.index')}}">
                    <i class="fas fa-users mr-2"></i>Personal
                </a>
                @endcan
                @can('Ver Especie')
                <a class="block text-gray-500 py-1.5 px-4 my-0 rounded transition duration-200 hover:bg-gradient-to-r hover:from-cyan-500 hover:to-cyan-500 hover:text-white" href="{{ route('Especie.index')}}">
                    <i class="fa-solid fa-paw mr-2"></i>Especies/Razas
                </a>
                @endcan
                @can('Ver Medicamento')
                <a class="block text-gray-500 py-1.5 px-4 my-0 rounded transition duration-200 hover:bg-gradient-to-r hover:from-cyan-500 hover:to-cyan-500 hover:text-white" href="{{ route('Medicamento.index')}}">
                    <i class="fas fa-pills mr-2"></i>Medicamentos
                </a>
                @endcan
                <a class="block text-gray-500 py-1.5 px-4 my-0 rounded transition duration-200 hover:bg-gradient-to-r hover:from-cyan-500 hover:to-cyan-500 hover:text-white" href="{{ route('producto.index')}}">
                    <i class="fa-brands fa-shopify mr-2"></i>Productos/Categorias
                </a>
                <a class="block text-gray-500 py-1.5 px-4 my-0 rounded transition duration-200 hover:bg-gradient-to-r hover:from-cyan-500 hover:to-cyan-500 hover:text-white" href="{{ route('pedido.index')}}">
                    <i class="fa-solid fa-address-book mr-2"></i>Realizar pedidos
                </a>
                <a class="block text-gray-500 py-1.5 px-4 my-0 rounded transition duration-200 hover:bg-gradient-to-r hover:from-cyan-500 hover:to-cyan-500 hover:text-white" href="{{ route('proveedor.index')}}">
                    <i class="fa-solid fa-comments-dollar"></i>Proveedor
                </a>
                @can('Ver Usuario')
                <a class="block text-gray-500 py-1.5 px-4 my-0 rounded transition duration-200 hover:bg-gradient-to-r hover:from-cyan-500 hover:to-cyan-500 hover:text-white" href="{{ route('Usuario.index')}}">
                    <i class="fa-solid fa-user mr-2"></i>Usuarios/Roles
                </a>
                @endcan
                @can('Ver Cliente')
                <a class="block text-gray-500 py-1.5 px-4 my-0 rounded transition duration-200 hover:bg-gradient-to-r hover:from-cyan-500 hover:to-cyan-500 hover:text-white" href="{{ route('Cliente.index')}}">
                    <i class="fa-solid fa-users mr-2"></i>Clientes
                </a>
                @endcan
                <a class="block text-gray-500 py-1.5 px-4 my-0 rounded transition duration-200 hover:bg-gradient-to-r hover:from-cyan-500 hover:to-cyan-500 hover:text-white" href="{{ route('Servicio.index')}}">
                    <i class="fa-solid fa-stethoscope mr-2"></i>Servicios
                </a>
                <a class="block text-gray-500 py-1.5 px-4 my-0 rounded transition duration-200 hover:bg-gradient-to-r hover:from-cyan-500 hover:to-cyan-500 hover:text-white" href="{{ route('NotaServicio.index')}}">
                    <i class="fa-regular fa-note-sticky mr-2"></i>Notas de Servicio
                </a>
                <a class="block text-gray-500 py-1.5 px-4 my-0 rounded transition duration-200 hover:bg-gradient-to-r hover:from-cyan-500 hover:to-cyan-500 hover:text-white" href="{{ route('Cita.index')}}">
                    <i class="fa-regular fa-note-sticky mr-2"></i>Citas
                </a>
                <a class="block text-gray-500 py-1.5 px-4 my-0 rounded transition duration-200 hover:bg-gradient-to-r hover:from-cyan-500 hover:to-cyan-500 hover:text-white" href="{{ route('Bitacora.twosteps')}}">
                    <i class="fa-regular fa-clipboard mr-2"></i>Bitacora
                </a>
            </nav>

            <!-- Ítem de Cerrar Sesión -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="block text-gray-500 py-2.5 px-4 my-2 rounded transition duration-200 hover:bg-gradient-to-r hover:from-cyan-500 hover:to-cyan-500 hover:text-white mt-auto" type="submit">Cerrar sesión</button>
            </form>


            <!-- Señalador de ubicación -->
            <div class="bg-gradient-to-r from-cyan-300 to-cyan-500 h-px mt-2"></div>

            <!-- Copyright al final de la navegación lateral -->
            <p class="mb-1 px-5 py-3 text-left text-xs text-cyan-500">Copyright Vetlink@2023</p>

        </div>

        <!-- Área de contenido principal -->
        <div class="flex-1 pt-0 w-full md:w-1/2">
            <!-- Campo de búsqueda 
            <div class="relative max-w-md w-full">
                <div class="absolute top-1 left-2 inline-flex items-center p-2">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input class="w-full h-10 pl-10 pr-4 py-1 text-base placeholder-gray-500 border rounded-full focus:shadow-outline" id="buscar" type="search" placeholder="Buscar...">
            </div> -->

            <!-- Contenedor de Gráficas -->
            <div class=" flex flex-wrap space-x-0 space-y-2 md:space-x-4 md:space-y-0">
                <!-- Primer contenedor -->
                <!-- Sección 1 - Gráfica de Usuarios -->
                <div class="flex-1 bg-white p-4 pt-0 shadow md:w-1/2">
                    @yield('Panza')
                </div>


            </div>

            <!-- Tercer contenedor debajo de los dos anteriores -->
            <!-- Sección 3 - Tabla de Autorizaciones Pendientes -->


            <!-- Cuarto contenedor -->
            <!-- Sección 4 - Tabla de Transacciones -->

        </div>
    </div>

</div>

<!-- Script para las gráficas -->
<script>
    // Gráfica de Usuarios


    // Agregar lógica para mostrar/ocultar la navegación lateral al hacer clic en el ícono de menú
    const menuBtn = document.getElementById('menuBtn');
    const sideNav = document.getElementById('sideNav');

    menuBtn.addEventListener('click', () => {
        sideNav.classList.toggle('hidden'); // Agrega o quita la clase 'hidden' para mostrar u ocultar la navegación lateral
    });

    document.addEventListener('DOMContentLoaded', function () {
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenuPopup = document.getElementById('user-menu-popup');
        const menuBtn = document.getElementById('menu-Btn');
        const navbaruser = document.getElementById('navbar-user');

        userMenuButton.addEventListener('click', function () {
            userMenuPopup.classList.toggle('hidden');
        });

        // Cierra el menú emergente al hacer clic en cualquier parte fuera de él
        window.addEventListener('click', function (event) {
            if (!userMenuButton.contains(event.target) && !userMenuPopup.contains(event.target)) {
                userMenuPopup.classList.add('hidden');
            }
        });

        menuBtn.addEventListener('click', function () {
            navbaruser.classList.toggle('hidden');
        });

        // Cierra el menú emergente al hacer clic en cualquier parte fuera de él
        window.addEventListener('click', function (event) {
            if (!menuBtn.contains(event.target) && !userMenuPopup.contains(event.target)) {
                navbaruser.classList.add('hidden');
            }
        });
    });
</script>
</body>

</html>