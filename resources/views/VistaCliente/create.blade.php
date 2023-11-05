@extends('Panza')

@section('Panza')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-semibold mb-4">Crear Nuevo Cliente</h2>
    
    <form action="{{ route('Cliente.store') }}" method="POST">
        @csrf
        
        <div class="mb-4">
            <label for="ci" class="block text-gray-700">CI:</label>
            <input type="text" name="ci" id="ci" class="form-input mt-1 w-full" require>
        </div>
        
        <div class="mb-4">
            <label for="nombre" class="block text-gray-700">Nombre:</label>
            <input type="text" name="nombre" id="nombre" class="form-input mt-1 w-full">
        </div>
        
        <div class="mb-4">
            <label for="correo" class="block text-gray-700">Correo:</label>
            <input type="email" name="correo" id="correo" class="form-input mt-1 w-full">
        </div>

        <div class="mb-4">
            <label for="telefono" class="block text-gray-700">Teléfono:</label>
            <input type="text" name="telefono" id="telefono" class="form-input mt-1 w-full">
        </div>
        
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
            Guardar Cliente
        </button>
    </form>
</div>

@endsection