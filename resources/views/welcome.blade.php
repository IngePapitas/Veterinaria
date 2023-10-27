@include('nav-welcome')

<!--Seccion hero (vista principal)-->
<div class="relative flex flex-col-reverse py-16 lg:pt-0 lg:flex-col lg:pb-0">
    <div class="inset-y-0 top-0 right-0 z-0 w-full max-w-xl px-4 mx-auto md:px-0 lg:pr-0 lg:mb-0 lg:mx-0 lg:w-7/12 lg:max-w-full lg:absolute xl:px-0">
        <svg class="absolute left-0 hidden h-full text-white transform -translate-x-1/2 lg:block" viewBox="0 0 100 100" fill="currentColor" preserveAspectRatio="none slice">
            <path d="M50 0H100L50 100H0L50 0Z"></path>
        </svg>
        <img
            class="object-cover w-full h-56 rounded shadow-lg lg:rounded-none lg:shadow-none md:h-96 lg:h-full"
            src="{{asset('images/portada2.jpeg')}}"
            alt="Vetlink"/>
    </div>
    <div class="relative flex flex-col items-start w-full max-w-xl px-4 mx-auto md:px-0 lg:px-8 lg:max-w-screen-xl">
        <div class="mb-16 lg:my-40 lg:max-w-lg lg:pr-5">
            <p class="inline-block px-3 py-px mb-4 text-xs font-semibold tracking-wider text-teal-900 uppercase rounded-full bg-teal-accent-400">
                Vetlink
            </p>
            <h2 class="mb-5 font-sans text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl sm:leading-none">
                Dedicados al bienestar<br class="hidden md:block" />
                de tus
                <span class="inline-block text-deep-purple-accent-400">mascotas</span>
            </h2>
            <p class="pr-5 mb-5 text-base text-gray-700 md:text-lg">
                Ofrecemos una amplia gama de servicios, desde consultas médicas hasta cirugías, y estamos disponibles para emergencias las 24 horas del día.            
            </p>
            <div class="flex items-center">
                <a href="#informacion" class="inline-flex items-center justify-center h-12 px-6 mr-6 font-medium tracking-wide text-black transition duration-200 rounded shadow-md bg-deep-purple-accent-400 hover:bg-deep-purple-accent-700 focus:shadow-outline focus:outline-none">Mas informacion</a>
                <a href="/" aria-label="" class="inline-flex items-center font-semibold text-gray-800 transition-colors duration-200 hover:text-deep-purple-accent-700"></a>
            </div>
        </div>
    </div>
</div>

<!--Seccion de informacion-->
<section class="text-gray-600" id="informacion">
    <div class="container px-5 py-24 mx-auto">
        <div class="flex flex-wrap -m-4">
            <div class="lg:w-1/3 lg:mb-0 mb-6 p-4">
                <div class="h-full text-center">
                    <img alt="testimonial" class="w-40 h-40 mb-8 object-cover object-center rounded-full inline-block border-2 border-gray-200 bg-gray-100" src="{{asset('images/ports.jpeg')}}">
                    <h2 class="text-gray-900 font-medium title-font tracking-wider text-sm">SERVICIOS VETERINARIOS</h2><br>
                    <p class="pr-2 mb-2 text-base text-gray-700">¡Descubre un Mundo de Servicios para Mascotas! En nuestra clínica veterinaria, nos apasiona brindar atención excepcional a tus queridos compañeros peludos. Desde tratamientos de belleza de primer nivel hasta cirugías salvavidas, ofrecemos todo lo que tus mascotas necesitan para una vida saludable y feliz.</p>
                    <span class="inline-block h-1 w-10 rounded bg-indigo-500 mt-6 mb-4"></span>
                    <p class="text-gray-500"></p>
                </div>
            </div>
            <div class="lg:w-1/3 lg:mb-0 mb-6 p-4">
                <div class="h-full text-center">
                    <img alt="testimonial" class="w-40 h-40 mb-8 object-cover object-center rounded-full inline-block border-2 border-gray-200 bg-gray-100" src="{{asset('images/especies.webp')}}">
                    <h2 class="text-gray-900 font-medium title-font tracking-wider text-sm">ATENCION A VARIEDAD DE ESPECIES</h2><br>
                    <p class="pr-2 mb-2 text-base text-gray-700">¡Cuidamos a Todos los Amigos de Cuatro Patas! En Vetlink, no hay límites para la variedad de animales que atendemos. Desde adorables perros y gatos hasta majestuosas aves, loros, y demas. Somos tu destino de confianza para todas las especies. ¡El reino animal es nuestro territorio!</p>
                    <span class="inline-block h-1 w-10 rounded bg-indigo-500 mt-6 mb-4"></span>
                    <p class="text-gray-500"></p>
                </div>
            </div>
            <div class="lg:w-1/3 lg:mb-0 mb-6 p-4">
                <div class="h-full text-center">
                    <img alt="testimonial" class="w-40 h-40 mb-8 object-cover object-center rounded-full inline-block border-2 border-gray-200 bg-gray-100" src="{{asset('images/compromiso.jpg')}}">
                    <h2 class="text-gray-900 font-medium title-font tracking-wider text-sm">NUESTRO COMPROMISO</h2><br>
                    <p class="pr-2 mb-2 text-base text-gray-700">En Vetlink, más que una clínica veterinaria, somos amantes apasionados de las mascotas. Nuestra misión es garantizar que cada animal, desde un encantador gatito hasta un leal compañero canino, obtenga el cuidado más excepcional. Estamos aquí para marcar la diferencia en la vida de tus mascotas.</p>
                    <span class="inline-block h-1 w-10 rounded bg-indigo-500 mt-6 mb-4"></span>
                    <p class="text-gray-500"></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!--Pie de pagina-->
@include('footer')