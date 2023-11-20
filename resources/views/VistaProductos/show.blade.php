
<!--SE MUESTRA AL CLIENTE ESTA PARTE-->
@include('nav-welcome')

    <div class="container mx-auto mt-8">
        <div class="bg-white shadow-md rounded p-4 lg:p-8">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <img src="{{ asset($p->imagen) }}" alt="Foto del producto" class="w-full h-auto lg:h-64 object-contain rounded-lg shadow-lg">
                </div>
                <div class="space-y-4">
                    <h3 class="text-2xl font-medium text-gray-800">{{ $p->nombre }}</h3>
                    <h3 class="text-2x2 font-medium text-gray-800">BOB. {{ $p->precio }}</h3>
                    <p class="text-sm text-gray-600">Cantidad disponible: {{ $p->stock }}</p>
                    <p class="text-gray-600">{{ $p->descripcion }}</p>

                    @auth
                        <form action="{{ route('carrito.update', $p->id) }}" method="post">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="producto_id" value="{{ $p->id }}">
                            <input type="hidden" name="producto_precio" value="{{ $p->precio }}">

                            <div class="flex items-center">
                                <input type="number" name="cantidad" placeholder="Cantidad" required min="1" max="{{ $p->stock }}" class="border border-gray-300 px-4 py-2 rounded-l-md w-32">
                                <button type="submit" class="bg-gray-700 text-white px-4 py-2 rounded-r-md hover:bg-gray-600 transition duration-300">Agregar al Carrito</button>
                            </div>
                        </form>
                    @else
                        <p class="text-red-600 bg-red-100 border border-red-600 rounded-md px-4 py-2">Inicia sesión para poder comprar</p>
                    @endauth
                </div>
            </div>
        </div>
    </div>

@include('footer')