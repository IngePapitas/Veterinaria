<x-guest-layout>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background: #ffff;
            background: linear-gradient(to right, #eafafe, #bdd3d6)
        }

        .custom-container {
            max-width: 500px; /* Ajusta el ancho máximo del contenedor */
        }
    </style>

    <!-- Comienzo del registro -->
    <div class="container custom-container mt-3 rounded shadow">
        <div class="row align-items-stretch">
            
            <div class="col bg-white p-5 rounded-end">
                <div class="text-end">
                    <img src="{{ asset('images/logo-prueba.jpg') }}" width="48" alt="">
                </div>
                <h2 class="fw-bold text-center py-3">Registro</h2>

                <!-- Verificación de la validación del registro -->
                <x-validation-errors class="mb-2" />

                <!-- Registro -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <!-- Nombre -->
                        <label class="form-label" for="name">{{ __('Nombre Completo') }}</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <!-- Correo Electrónico -->
                        <label class="form-label" for="email">{{ __('Correo Electrónico') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <!-- Contraseña -->
                        <label class="form-label" for="password">{{ __('Contraseña') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <!-- Confirmación de Contraseña -->
                        <label class="form-label" for="password_confirmation">{{ __('Confirmar Contraseña') }}</label>
                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">{{ __('Registrarse') }}</button>
                    </div>

                    <div class="my-3">
                        <span>¿Ya tienes una cuenta? <a href="{{ route('login') }}">Inicia Sesión</a></span>
                    </div>
                </form>

                <div class="container">
                    <div class="row">
                        <div class="col">
                            <a href="/" class="float-end"> Menu principal</a>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</x-guest-layout>
