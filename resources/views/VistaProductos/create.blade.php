@extends('Panza')

@section('Panza')
    @if ($categorias->isEmpty() || $marcas->isEmpty())
        <div class="w-full lg:w-1/2 mx-auto mb-8">
            <div class="bg-red-100 border border-red-600 rounded-md p-4">
                <p class="text-red-600 text-lg font-semibold mb-4">
                    @if ($categorias->isEmpty())
                        <a href="{{ route('categoria.index') }}" class="text-black hover:underline">
                            Primero debe registrar una categoría
                        </a>
                    @else
                        <a href="{{ route('marca.index') }}" class="text-black hover:underline">
                            Primero debe registrar una marca
                        </a>
                    @endif
                </p>
            </div>
        </div>
    @else
    <div class="max-w-4xl mx-auto px-4 my-8">
        <div class="bg-white shadow-lg rounded-lg p-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Registro de Producto</h2>
            <form action="{{ route('producto.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="categoria" class="text-gray-600 font-semibold">Categoría:</label>
                        <select name="categoria" id="categoria" required
                            class="form-select mt-2 block w-full border-gray-300 rounded-lg focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                            <option value="" disabled selected>Elige una categoría</option>
                            @forelse ($categorias as $c)
                                <option value="{{ $c->id }}">{{ $c->categoria }}</option>
                            @empty
                                <option value="" disabled>No hay categorías disponibles</option>
                            @endforelse
                        </select>
                    </div>
                    <div>
                        <label for="marca" class="text-gray-600 font-semibold">Marca:</label>
                        <select name="marca" id="marca" required
                            class="form-select mt-2 block w-full border-gray-300 rounded-lg focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                            <option value="" disabled selected>Elige una marca</option>
                            @forelse ($marcas as $m)
                                <option value="{{ $m->id }}">{{ $m->nombre }}</option>
                            @empty
                                <option value="" disabled>No hay marcas disponibles</option>
                            @endforelse
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label for="foto" class="text-gray-600 font-semibold">Foto:</label>
                        <input type="file" name="foto" id="foto" required
                            class="form-input mt-2 block w-full border-gray-300 rounded-lg focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                    </div>
                    <div>
                        <label for="nombre" class="text-gray-600 font-semibold">Nombre del producto:</label>
                        <input type="text" name="nombre" id="nombre" required
                            class="form-input mt-2 block w-full border-gray-300 rounded-lg focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                    </div>
                </div>
                <div class="mt-6">
                    <label for="descripcion" class="text-gray-600 font-semibold">Descripción:</label>
                    <textarea name="descripcion" id="descripcion" required
                        class="form-textarea mt-2 block w-full border-gray-300 rounded-lg focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50"></textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label for="cant_min" class="text-gray-600 font-semibold">Stock Mínimo:</label>
                        <input type="number" name="cant_min" id="cant_min" required
                            class="form-input mt-2 block w-full border-gray-300 rounded-lg focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                    </div>
                    <div>
                        <label for="precio" class="text-gray-600 font-semibold">Precio:</label>
                        <input type="number" name="precio" id="precio" required
                            class="form-input mt-2 block w-full border-gray-300 rounded-lg focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                    </div>
                </div>
                <div class="mt-8 flex justify-end">
                    <button class="bg-green-500 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-full focus:outline-none focus:shadow-outline">Guardar</button>
                    <a href="{{ route('producto.index') }}"
                        class="bg-red-500 hover:bg-red-700 text-white font-semibold py-2 px-6 ml-4 rounded-full">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
    @endif
@endsection
