@extends('Panza')

@section('Panza')
    <div class="container mx-auto px-4 py-8">

        <div class="wrap-2 flex">
            <div class="mb-4 pr-2">
                <a href="{{ route('Raza.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Registrar Raza
                </a>
            </div>
            <div class="mb-4 ml-auto">
                <a href="{{ route('Especie.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Ir a Especies
                </a>
            </div>
        </div>

        <div class="mb-4">
            <label for="ordenar" class="block text-gray-700">Ordenar por:</label>
            <select id="ordenar" class="form-select mt-1 block w-full">
                <option value="id">ID (por defecto)</option>
                <option value="nombre">Tipo de raza</option> 
                <option value="nombre">Especie</option> 
            </select>
        </div>


        <table id="tabla-muestra" class="table-auto w-full text-center">
            <thead>
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Tipo de raza</th>
                    <th class="px-4 py-2">Especie</th>
                    <th class="px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($raza as $r)
                <tr>
                    <td class="px-4 py-2">{{ $r->id }}</td>
                    <td class="px-4 py-2">{{ $r->nombre }}</td>
                    <td class="px-4 py-2">
                        @foreach($especie as $e)
                            @if($e->id === $r->id_especie)
                                {{ $e->nombre }}
                            @endif
                        @endforeach
                    </td>
                    <td class= "px-4 py-2">
                        <a href="{{ route('Raza.edit', $r) }}" class="text-blue-600 hover:text-gray-800 pr-2">
                            Editar
                        </a>
                        <!--FALTA LA PARTE DE EDITAR-->
                        <form action="{{ route('Raza.destroy', $r->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
