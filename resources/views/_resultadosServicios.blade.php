@foreach($servicios as $servicio)
<tr>
    <td class="border px-4 py-2">{{ $servicio->id }}</td>
    <td class="border px-4 py-2">{{ $servicio->descripcion }}</td>
    <td class="border px-4 py-2">{{ $servicio->precio }} Bs.</td>
    <td class="border px-4 py-2">
        <a href="{{ route('Servicio.edit', $servicio->id) }}" class="text-blue-600 hover:text-gray-800">
            Editar
        </a>
        <form action="{{ route('Servicio.destroy', $servicio->id) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-600 hover:text-red-800 ml-2">
                Eliminar
            </button>
        </form>
    </td>

</tr>
@endforeach