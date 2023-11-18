@extends('Panza')

@section('Panza')
    @if ($categorias->isEmpty())
        <div class="w-full lg:w-1/2 mx-auto mb-4">
            <p class="my-8 text-red-600 bg-red-100 border border-red-600 rounded-md px-4 py-2 mb-4">
                <a href="{{ route('categoria.create') }}">
                    Primero debe registrar una categoría
                </a>
            </p>
        </div>
    @else
        <div class="w-full lg:w-1/2 mx-auto my-4">
            <h2 class="text-2xl font-bold text-black mt-8 mb-4 ml-4 uppercase">Actualizar Producto:</h2>
            <form action="{{ route('producto.update', $p->id) }}" method="POST" enctype="multipart/form-data"
                class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="categoria">Categoría:</label>
                        <select name="categoria" id="categoria" required class="border border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-green-500">
                            <option disabled>Elige una categoría</option>
                            @forelse ($categorias as $c)
                                <option value="{{ $c->id }}" {{ $p->categoria_id == $c->id ? 'selected' : '' }}>{{ $c->categoria }}</option>
                            @empty
                                <option disabled>Registra una nueva categoría</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="marca">Marca:</label>
                        <select name="marca" id="marca" required class="border border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-green-500">
                            <option disabled>Elige una marca</option>
                            @forelse ($marcas as $m)
                                <option value="{{ $m->id }}" {{ $p->marca_id == $m->id ? 'selected' : '' }}>{{ $m->nombre }}</option>
                            @empty
                                <option disabled>Registra una nueva marca</option>
                            @endforelse
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="foto">Foto:</label>
                    @if ($p->imagen)
                        <img src="{{ asset($p->imagen) }}" alt="Imagen actual" class="mb-2" width="150">
                        <input type="hidden" name="imagen_actual" value="{{ $p->imagen }}">
                    @endif
                    <input type="file" name="foto" id="foto" accept="image/*"
                        class="border border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-green-500">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nombre">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" required value="{{ $p->nombre }}"
                        class="border border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-green-500">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="descripcion">Descripción:</label>
                    <textarea name="descripcion" id="descripcion" required
                        class="border border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-green-500">{{ $p->descripcion }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="stock_min">Stock Mínimo:</label>
                        <input type="number" name="stock_min" value="{{ $p->stock_min }}"
                            class="border border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-green-500">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="precio">Precio:</label>
                        <input type="number" name="precio" id="precio" required value="{{ $p->precio }}"
                            class="border border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-green-500">
                    </div>

                <div class="flex items-center justify-between mb-4">
                    <button
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Actualizar</button>
                    <a href="{{ route('producto.index') }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Cancelar</a>
                </div>
            </form>
        </div>
    @endif
@endsection
