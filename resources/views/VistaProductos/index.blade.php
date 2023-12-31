@extends('Panza')

@section('Panza')
    <div class="mb-4">
        <a href="{{ route('marca.index') }}" class="bg-blue-500 hover:bg-blue-600 m-4 text-white font-bold py-2 px-4 rounded">
            Marcas
        </a>
        <a href="{{ route('categoria.index') }}" class="bg-blue-500 hover:bg-blue-600 m-4 text-white font-bold py-2 px-4 rounded">
            Categorias
        </a>
        <a href="{{ route('producto.index') }}" class="bg-blue-500 hover:bg-blue-600 m-4 text-white font-bold py-2 px-4 rounded">
            Productos
        </a>
    </div>
    <div class="md:col-span-3">
        <a href="{{ route('producto.create') }}" class="block w-full bg-green-500 text-white px-4 py-2 rounded-md text-center transition duration-300 ease-in-out hover:bg-green-600 hover:text-gray-100">Registrar Productos</a>
    </div>
<div>
    @foreach ($categorias as $categoria)
        <h2 class="text-2xl font-bold text-black mt-8 mb-4 ml-4 uppercase">Categoría: {{ $categoria->categoria }}</h2>
        <!-- Contenedor de productos -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-8">
            @foreach ($categoria->productos as $producto)
                <div class="bg-white p-4 shadow-md">
                    <div class="grid grid-cols-[1fr,3fr]">
                        <div>
                            <img src="{{ asset($producto->imagen) }}" alt="Foto del producto" class="w-32 h-32 object-cover rounded-md mb-2">
                            <a href="{{ route('producto.edit', $producto->id) }}"
                                class="bg-blue-500 text-white px-4 py-2 rounded-md mr-2">Editar</a>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-lg font-bold">{{ $producto->nombre }}</h2>
                            <p class="mb-2">Stock: {{ $producto->stock }}</p>
                            <p class="mb-2">{{ $producto->descripcion }}</p>
                            <p class="text-lg font-semibold">Precio: {{ $producto->precio }}</p>
                            <p class="text-sm text-gray-600">Creado el: {{ $producto->created_at->format('d/m/Y') }}</p>
                            <form action="{{ route('producto.destroy', $producto->id) }}" method="POST"
                                class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash"
                                        width="20" height="20" viewBox="0 0 24 24" stroke-width="2.5"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <!-- ... tu SVG ... -->
                                        <path stroke="none" d="M0 0h24v24H0z" />
                                        <line x1="4" y1="7" x2="20" y2="7" />
                                        <line x1="10" y1="11" x2="10" y2="17" />
                                        <line x1="14" y1="11" x2="14" y2="17" />
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>



@endsection
