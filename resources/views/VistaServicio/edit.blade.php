@extends('Panza')

@section('Panza')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-semibold mb-4">Editar Servicio</h2>
    
    <form action="{{ route('Servicio.update', $servicio->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label for="descripcion" class="block text-gray-700">Descripción:</label>
            <input type="text" name="descripcion" id="descripcion" class="form-input mt-1 w-full" value="{{ $servicio->descripcion }}">
        </div>
        
        <div class="mb-4">
            <label for="precio" class="block text-gray-700">Precio:</label>
            <input type="text" name="precio" id="precio" class="form-input mt-1 w-full" value="{{ $servicio->precio }}">
        </div>
        
        <select class="block mb-4" name="tipo_servicio">
        @foreach($tipoServicios as $tipoServicio)
            <option value="{{$tipoServicio->id}}" {{ $servicio->id_tipo_servicio == $tipoServicio->id ? 'selected' : '' }}>{{$tipoServicio->nombre}}</option>
        @endforeach
        </select>

        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
            Actualizar Servicio
        </button>
    </form>
</div>
@endsection
