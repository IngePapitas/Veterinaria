<!-- Scripts -->
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

</head>
<nav class="bg-white border-gray-200 dark:bg-gray-900">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="/" class="flex items-center">
            <img src="{{asset('images/logo-prueba.jpg')}}" class="h-8 mr-3" alt="Vetlink" />
            <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Vetlink</span>
        </a>
        <!--Usuario-->
        <div class="flex items-center md:order-2">
            @if (Auth::check())
                <div class="relative group">
                    <button class="flex items-center" id="user-menu-button">
                        <img class="w-8 h-8 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
                        <span class="ml-2 text-sm font-medium text-gray-900 hidden md:inline dark:text-white dark:hover:text-gray-400">{{ Auth::user()->name }}</span>
                    </button>
                    <!-- Contenedor emergente para opciones de perfil y cerrar sesión -->
                    <div id="user-menu-popup" class="hidden absolute right-0 mt-2 py-2 w-36 bg-white rounded-lg shadow-lg z-50">
                        <button class="block text-gray-900 py-2.5 px-4 my-2 rounded transition duration-200 hover:bg-gradient-to-r hover:from-blue-500 hover:to-blue-700 hover:text-white mt-auto w-full" type="submit">
                            <a href="{{ route('profile.show') }}">Perfil</a>
                        </button>
                        <button class="block text-gray-900 py-2.5 px-4 my-2 rounded transition duration-200 hover:bg-gradient-to-r hover:from-blue-500 hover:to-blue-700 hover:text-white mt-auto w-full" type="submit">
                            <a href="{{ route('mismascotas') }}">Mis mascotas</a>
                        </button>
                        <!-- Ítem de Cerrar Sesión -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="block text-gray-900 py-2.5 px-4 my-2 rounded transition duration-200 hover:bg-gradient-to-r hover:from-blue-500 hover:to-blue-700 hover:text-white mt-auto w-full" type="submit">Cerrar sesión</button>
                        </form>                   
                    </div>
                </div>
            @else
                <div class="wrap-2 flex">
                    <div class="pr-2">
                        <button type="button" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center mr-2 md:mr-0 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <a href="{{ route('login') }}">
                                Iniciar Sesion
                            </a>
                        </button>
                    </div>
                    <div>
                        <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover-bg-blue-700 dark:focus:ring-blue-800">
                            <a href="{{ route('register') }}">
                                Registrate
                            </a>
                        </button>
                    </div>
                    
                </div>
            @endif
        </div>

        <!---Links de paginas-->
        <div class="relative group">
            <div class="md:hidden flex items-center relative"> <!-- Se muestra solo en dispositivos pequeños -->
                <button id="menu-Btn">
                    <i class="fas fa-bars text-gray-500 text-lg"></i> <!-- Ícono de menú -->
                </button>
                <!-- Contenedor emergente para opciones de perfil y cerrar sesión -->
                <div id="navbar-user" class="hidden absolute right-0 top-10 transform translate-y-2 w-36 bg-white rounded-lg shadow-lg z-50">
                    <a href="{{ route('welcome') }}" class="block px-4 py-2 text-gray-900 rounded hover:bg-blue-700 hover:text-white md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Inicio</a>
                    <a href="{{ route('servicios-ofrecidos') }}" class="block px-4 py-2 text-gray-900 rounded hover:bg-blue-700 hover:text-white md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Servicios</a>
                    <a href="{{ route('productos') }}" class="block px-4 py-2 text-gray-900 rounded hover:bg-blue-700 hover:text-white md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Productos</a>
                    <a href="{{ route('contacto') }}" class="block px-4 py-2 text-gray-900 rounded hover:bg-blue-700 hover:text-white md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Contacto</a>
                    <a href="{{ route('equipo') }}" class="block px-4 py-2 text-gray-900 rounded hover:bg-blue-700 hover:text-white md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Nuestro Equipo</a>
                </div>
            </div>

            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" >
                <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                    <li >
                        <x-nav-link href="{{ route('welcome') }}" :active="request()->routeIs('welcome')">
                            {{ __('Inicio') }}
                        </x-nav-link>
                    </li>                    
                    <li>
                        <x-nav-link href="{{ route('servicios-ofrecidos') }}" :active="request()->routeIs('servicios-ofrecidos')">
                            {{ __('Servicios') }}
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link href="{{ route('productos') }}" :active="request()->routeIs('productos')">
                            {{ __('Productos') }}
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link href="{{ route('contacto') }}" :active="request()->routeIs('contacto')">
                            {{ __('Contacto') }}
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link href="{{ route('equipo') }}" :active="request()->routeIs('equipo')">
                            {{ __('Nuestro Equipo') }}
                        </x-nav-link>
                    </li>
                    
                </ul>
            </div>
        </div>
    </div>
</nav>

<script>
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