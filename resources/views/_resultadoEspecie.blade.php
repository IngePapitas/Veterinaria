@foreach($especies as $especie)
<tr class="border-t-2 border-gray-200">
    <td class="border px-4 py-2">
        {{ $especie->id }}
    </td>
    <td class="border px-4 py-2">
        @if($especie->imagen_path)
            <img src="{{ Storage::url($especie->imagen_path) }}" alt="{{ $especie->nombre }}" class="h-20 w-20 object-cover rounded-full">
        @else
            <img src="{{ Storage::url('AvataresPacientes/can.jpg') }}" alt="{{ $especie->nombre }}" class="h-20 w-20 object-cover rounded-full">
        @endif
    </td>
    <td class="border px-4 py-2">
        {{ $especie->nombre }}
    </td>
    <td class="border px-4 py-2">
        <ul>
            @foreach($raza as $r)
                @if($r->id_especie === $especie->id)
                    <li>{{ $r->nombre }}</li>
                @endif
            @endforeach
        </ul>
    </td>
    <td class="border px-4 py-2">
        <a href="{{ route('Especie.edit', $especie->id) }}" class="text-blue-600 hover:text-gray-800">
            Editar
        </a>
        <form action="{{ route('Especie.destroy', $especie->id) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-600 hover:text-red-800">
                Eliminar
            </button>
        </form>
    </td>
</tr>
@endforeach