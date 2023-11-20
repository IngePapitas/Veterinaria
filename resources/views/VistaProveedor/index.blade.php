@extends('Panza')

@section('Panza')
    
    <div class="md:col-span-3">
        <div class="mt-4 mb-4">
            <a href="{{ route('proveedor.index') }}" class="bg-blue-500 hover:bg-blue-600 m-4 text-white font-bold py-2 px-4 rounded">
                Proveedor
            </a>
        </div>
        <a href="{{ route('proveedor.create') }}" class="block w-full bg-green-500 text-white px-4 py-2 rounded-md text-center transition duration-300 ease-in-out hover:bg-green-600 hover:text-gray-100">Registrar Proveedor</a>
    </div>

    <div class="container mx-auto px-4 my-4">
        <div class="w-full lg:w-3/4 mx-auto mb-4">
            <div class="overflow-x-auto my-6 shadow-md rounded">
                @if (count($arrayProveedores) > 0)
                    <table class="min-w-full table-auto border border-gray-200 mt-4">
                        <thead>
                            <tr>
                                <th class="bg-gray-100 px-6 py-3 border-b border-gray-200 text-left text-sm leading-4 font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="bg-gray-100 px-6 py-3 border-b border-gray-200 text-left text-sm leading-4 font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                <th class="bg-gray-100 px-6 py-3 border-b border-gray-200 text-left text-sm leading-4 font-medium text-gray-500 uppercase tracking-wider">Teléfono</th>
                                <th class="bg-gray-100 px-6 py-3 border-b border-gray-200 text-left text-sm leading-4 font-medium text-gray-500 uppercase tracking-wider">Marca</th>
                                <th class="bg-gray-100 px-6 py-3 border-b border-gray-200 text-center text-sm leading-4 font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($arrayProveedores as $p)
                                <tr>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">{{ $p['id'] }}</td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">{{ $p['nombre'] }}</td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">{{ $p['telefono'] }}</td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">{{ $p['marca']}}</td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-center border-b border-gray-200">
                                        <a href="{{ route('proveedor.edit', $p['id']) }}" class="text-blue-500 hover:text-green-700 mr-2">Editar</a>
                                        <form action="{{ route('proveedor.destroy', $p['id']) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="20" height="20" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" />
                                                    <line x1="4" y1="7" x2="20" y2="7" />
                                                    <line x1="10" y1="11" x2="10" y2="17" />
                                                    <line x1="14" y1="11" x2="14" y2="17" />
                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-center">No hay proveedores registrados.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
