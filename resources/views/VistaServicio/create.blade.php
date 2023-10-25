@extends('Panza')

@section('Panza')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-semibold mb-4">Crear Nuevo Servicio</h2>
    
    <form action="{{ route('Servicio.store') }}" method="POST">
        @csrf
        
        
        <div class="mb-4">
            <label for="descripcion" class="block text-gray-700">Descripcion:</label>
            <input type="text" name="descripcion" id="descripcion" class="form-input mt-1 w-full">
        </div>
        
        <div class="mb-4">
            <label for="precio" class="block text-gray-700">Precio:</label>
            <input type="text" name="precio" id="precio" class="form-input mt-1 w-full">
        </div>

        
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
            Guardar Servicio
        </button>
    </form>
</div>

@endsection