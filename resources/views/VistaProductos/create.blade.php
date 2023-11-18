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
        <div class="w-full lg:w-2/3 mx-auto my-8">
            <div class="bg-white shadow-lg rounded-lg p-8">
                <h2 class="text-3xl font-extrabold text-gray-800 mb-6">Registro de Producto</h2>
                <form action="{{ route('producto.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label for="categoria" class="text-gray-600 font-semibold text-sm">Categoría:</label>
                            <select name="categoria" id="categoria" required
                                class="border border-gray-400 rounded-lg w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:border-green-500">
                                <option selected disabled>Elige una categoría</option>
                                @forelse ($categorias as $c)
                                    <option value="{{ $c->id }}">{{ $c->categoria }}</option>
                                @empty
                                    <option disabled>Registra una nueva categoría</option>
                                @endforelse
                            </select>
                        </div>
                        <div>
                            <label for="marca" class="text-gray-600 font-semibold text-sm">Marca:</label>
                            <select name="marca" id="marca" required
                                class="border border-gray-400 rounded-lg w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:border-green-500">
                                <option selected disabled>Elige una marca</option>
                                @forelse ($marcas as $m)
                                    <option value="{{ $m->id }}">{{ $m->nombre }}</option>
                                @empty
                                    <option disabled>Registra una nueva marca</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="mt-6">
                            <label for="foto" class="text-gray-600 font-semibold text-sm">Foto:</label>
                            <input type="file" name="foto" id="foto" required
                                class="border border-gray-400 rounded-lg w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:border-green-500">
                        </div>
                        <div class="mt-6">
                            <label for="nombre" class="text-gray-600 font-semibold text-sm">Nombre del producto:</label>
                            <input type="text" name="nombre" id="nombre" required
                                class="border border-gray-400 rounded-lg w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:border-green-500">
                        </div>
                    </div>
                    <div class="mt-6">
                        <label for="descripcion" class="text-gray-600 font-semibold text-sm">Descripción:</label>
                        <textarea name="descripcion" id="descripcion" required
                            class="border border-gray-400 rounded-lg w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:border-green-500"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="mt-6">
                            <label for="cant_min" class="text-gray-600 font-semibold text-sm">Stock Mínimo:</label>
                            <input type="number" name="cant_min" id="cant_min" required
                                class="border border-gray-400 rounded-lg w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:border-green-500">
                        </div>
                        <div class="mt-6">
                            <label for="precio" class="text-gray-600 font-semibold text-sm">Precio:</label>
                            <input type="number" name="precio" id="precio" required
                                class="border border-gray-400 rounded-lg w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:border-green-500">
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
