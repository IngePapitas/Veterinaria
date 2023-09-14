@foreach($personals as $personal)
<tr>
    <td class="border px-4 py-2">{{ $personal->id }}</td>
    <td class="border px-4 py-2 ">
        <img src="{{ Storage::url($personal->imagen_path) }}" alt="{{ $personal->nombre }}" class="h-20 w-20 object-cover rounded-full">
    </td>
    <td class="border px-4 py-2">{{ $personal->nombre }}</td>
    <!-- <td class="border px-4 py-2">{{ $producto->descripcion }}</td> -->

    <td class="border px-2 py-2">
        @php
        $especialidad = $personal->especialidad;
        @endphp
        {{ $especialidad ? $especialidad->descripcion : 'Sin especialidad' }}
    </td>
    <td class="border px-4 py-2">{{ $personal->salario }}</td>
    <td class="border px-4 py-2">
        <a href="{{ route('Personal.edit', $personal->id) }}" class="text-blue-600 hover:text-gray-800">
            Editar
        </a>
        <form action="{{ route('Personal.destroy', $personal->id) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-600 hover:text-red-800 ml-2">
                Eliminar
            </button>
        </form>
    </td>
</tr>
@endforeach