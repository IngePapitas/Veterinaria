<x-guest-layout>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <div class="container">
        <div class="row">
            <div class="col">

            </div>
            <div class="col">
                <div class="text-end">
                    <img src="{{asset('images/logo-prueba.jpg')}}" width="48" alt="">
                </div>
                <h2 class="fw-bold text-center py-5">Bienvenido</h2>

                <!--LOGIN-->
                <form action="#">
                    <div class="mb-4">
                        <label for="email" class="form-label"> Correo Electronico</label>
                        <input type="email" class="form-control" name="email">
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label"> Contraseña</label>
                        <input type="password" class="form-control" name="password">
                    </div>
                    <div class="mb-4 form-check">
                        <input type="checkbox" name="connected" class="form-check-input">
                        <label for="connected" class="form-check-label">Mantenerme conectado</label>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Iniciar Sesion</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--<x-authentication-card>        
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ml-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form> 
    </x-authentication-card> -->
</x-guest-layout>
