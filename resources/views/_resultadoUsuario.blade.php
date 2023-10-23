@foreach($usuarios as $usuario)
<tr>
    <td class="border px-4 py-2">{{ $usuario->id }}</td>
    <td class="border px-4 py-2 ">
        @if($usuario->imagen_path)
        <img src="{{ Storage::url($usuario->imagen_path) }}" alt="{{ $usuario->nombre }}" class="h-20 w-20 object-cover rounded-full">
        @else
            
                <img src="{{ Storage::url('Avatares/Hombre.jpg') }}" alt="Avatar Mujer" class="h-20 w-20 object-cover rounded-full">
            
        @endif
    </td>
    <td class="border px-4 py-2">{{ $usuario->name }}</td>
    <td class="border px-4 py-2">{{ $usuario->email }}</td>
    @can('Editar Usuario')
    <td class="border px-4 py-2">
        <a href="{{ route('Usuario.edit', $usuario->id) }}" class="text-blue-600 hover:text-gray-800">
            Editar
        </a>
        <form action="{{ route('Usuario.destroy', $usuario->id) }}" method="POST" class="inline">
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