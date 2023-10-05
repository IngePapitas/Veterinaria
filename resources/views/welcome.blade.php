<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veterinaria ...</title>
    <link rel="icon" href="{{asset('images/logo-prueba.jpg')}}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <!--Estilos para la pagina principal -->
    <style>
        body {
            background: #ffff;
            background: linear-gradient(to right, #eafafe, #bdd3d6)
        }

        .jumbotron {
            background-color: #007bff;
            color: white;
            padding: 100px 0;
            margin-bottom: 0;
        }

        .jumbotron h1 {
            font-size: 3rem;
        }

        .jumbotron p {
            font-size: 1.5rem;
        }

        .feature-icon {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .feature-title {
            font-size: 1.5rem;
            margin-bottom: 5px;
        }
        /* Estilos personalizados para el contenedor con imagen de fondo */
        .jumbotron {
            background-image: url('{{asset('images/fondo-principal.jpg')}}'); /* Ruta de tu imagen de fondo */
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            color: white; /* Color del texto */
        }

        /* Estilos para el contenido dentro del contenedor */
        .jumbotron .container {
            background-color: rgba(0, 0, 0, 0.6); /* Fondo semitransparente para hacer el texto más legible */
            padding: 20px;
            border-radius: 10px;
        }
        .jumbotron h1, .jumbotron p {
        font-weight: bold; /* Hace que el texto sea más grueso */
        }

    </style>
</head>
<body>
    <!-- Encabezado (MEJORAR Y SECCIONES DE PRUEBA LUEGO VER QUE IMPLEMENTAR)-->
    <header>
        <nav class="navbar navbar-expand-lg ">
            <div class="container">
                <img src="{{asset('images/logo-prueba.jpg')}}" width="48" alt="">
                <a class="navbar-brand" href="#">Veterinaria</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Servicios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contacto</a>
                        </li>
                    </ul>
                </div>
                <div class="navbar-nav ml-auto">
                    <a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
                    <a class="nav-link" href="{{ route('register') }}">Registrarse</a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Sección de Bienvenida -->
    <section class="jumbotron text-center">
        <div class="container">
            <h1 class="display-4">Bienvenido a la Veterinaria .....</h1>
            <p class="lead">Cuidamos y amamos a tus mascotas.</p>
        </div>
    </section>

    <!-- Sección de Características (COMPLETAR MEJOR SOLO VISTA DE PRUEBA)-->
    <section class="container mt-5">
        <div class="row">
            <div class="col-md-4 text-center">
                <i class="feature-icon fas fa-paw"></i>
                <h2 class="feature-title">Atención Personalizada</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>
            <div class="col-md-4 text-center">
                <i class="feature-icon fas fa-stethoscope"></i>
                <h2 class="feature-title">Profesionales Veterinarios</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>
            <div class="col-md-4 text-center">
                <i class="feature-icon fas fa-heart"></i>
                <h2 class="feature-title">Amor por los Animales</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>
        </div>
    </section>

    <!-- Sección de Productos (si se hace OPCIONAL DE PRUEBA) -->
    <section class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="product-container">
                    <!-- Aquí agregar los campos de productos y llamar al controlador -->
                    <h2 class="text-center">Nuestros Productos</h2>
                    <!-- Ejemplo de un enlace para ver más productos -->
                    <p class="text-center"><a href="" class="btn btn-primary">Ver Más Productos</a></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de Contacto (DUDA SI APARTE O EN EL PIE DE PAGINA)-->
    <section class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <h2>Contacto</h2>
                <p>Estamos aquí para ayudarte con el cuidado de tus mascotas. Contáctanos para obtener más información.</p>
                <ul>
                    <li><i class="fas fa-phone"></i> Teléfono: (+591) 0000-0000</li>
                    <li><i class="fas fa-envelope"></i> Correo Electrónico: info@veterinaria.com</li>
                    <li><i class="fas fa-envelope"></i> Dirección: Santa Cruz.........</li>

                </ul>
            </div>
            <div class="col-md-2">
                <img src="https://via.placeholder.com/400" alt="Imagen de contacto" class="img-fluid">
            </div>
        </div>
    </section>

    <!-- Pie de Página -->
    <footer class="text-center py-3">
        <div class="container">
            <p>&copy; 2023 Veterinaria .... . Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>
