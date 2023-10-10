<x-guest-layout>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body{
            background: #ffff;
            background: linear-gradient(to right, #eafafe, #bdd3d6)
        }
    </style>
        

        <!-- Comienzo del login-->
        <div class="container w-40 bg-white mt-3 rounded shadow">
            <div class="row align-items-stretch">

                <div class="col bg d-none d-lg-block col-md-5 col-lg-5 col-xl-6 rounded p-0">
                    <img src="{{asset("images/ports.jpeg")}}" alt="" class="img-fluid">
                </div>

                <div class="col bg-white p-5 rounded-end ">
                    <div class="text-end">
                        <img src="{{asset('images/logo-prueba.jpg')}}" width="48" alt="">
                    </div>
                    <h2 class="fw-bold text-center py-3">Bienvenido a Vetlink</h2>
                    <!--Verificacion de la validacion de inicio de sesion-->
                    <x-validation-errors class="mb-2" />
                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                            </div>
                    @endif
                    <!--LOGIN-->
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-2">  <!--Email-->
                            <label class="form-label" for="email">{{ __('Correo Electronico') }}</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
    
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                        </div>
                        <div class="mb-2"> <!-- Contra-->
                            <label class="form-label" for="password">{{ __('Contraseña') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    
                                    @error('password')<!--Comprueba la contraseña-->
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="mb-2"><!--Contrasena olvidada-->
                            @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="small text-muted">Has olvidado la contraseña?</a>
                            @endif
                        </div>

                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">{{ __('Recuerdame') }}</label>
                        </div> 

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">{{ __('Iniciar Sesion') }}</button>
                        </div>

                        <div class="my-3">
                            <span>No tienes cuenta? <a href="{{ route('register') }}">Registrate</a></span>
                        </div>

                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <a href="/" class="float-end"> Menu principal</a>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>-->
</x-guest-layout>
