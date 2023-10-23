@foreach($roles as $rol)
<tr>
    <td class="border px-4 py-2">{{ $rol->id }}</td>
    <td class="border px-4 py-2">{{ $rol->name }}</td>
    <td class="border px-4 py-2">
        <a href="{{ route('Role.edit', $rol->id) }}" class="text-blue-600 hover:text-gray-800">
            Editar
        </a>
        <form action="{{ route('Role.destroy', $rol->id) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-600 hover:text-red-800 ml-2">
                Eliminar
            </button>
        </form>
    </td>
</tr>
@endforeach