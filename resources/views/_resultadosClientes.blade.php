@foreach($clientes as $cliente)
                <tr>
                    <td class="border px-4 py-2">{{ $cliente->id }}</td>
                    <td class="border px-4 py-2">{{ $cliente->ci }}</td>
                    <td class="border px-4 py-2">{{ $cliente->nombre }}</td>
                    <td class="border px-2 py-2">{{ $cliente->telefono }}</td>
                    <td class="border px-4 py-2">{{ $cliente->correo }}</td>
                    @can('Editar Cliente')
                    <td class="border px-4 py-2">
                        <a href="{{ route('Cliente.edit', $cliente->id) }}" class="text-blue-600 hover:text-gray-800">
                            Editar
                        </a>
                        <form action="{{ route('Cliente.destroy', $cliente->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 ml-2">
                                Eliminar
                            </button>
                        </form>
                    </td>
                    @endcan
                </tr>
@endforeach
