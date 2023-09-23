@foreach($personals as $personal)
@if($personal->estado === 0)
<tr class="{{ $personal->baja === 1 ? ' bg-red-200' : '' }}">
    <td class="border px-4 py-2 ">{{ $personal->id }}</td>
    <td class="border px-4 py-2">
        @if($personal->imagen_path)
        <img src="{{ Storage::url($personal->imagen_path) }}" alt="{{ $personal->nombre }}" class="h-20 w-20 object-cover rounded-full">
        @else
        @if($personal->sexo === 'Mujer')
        <img src="{{ Storage::url('AvataresDoctor/AvatarMujer.jpeg') }}" alt="Avatar Mujer" class="h-20 w-20 object-cover rounded-full">
        @else
        <img src="{{ Storage::url('AvataresDoctor/AvatarDoctor.jpeg') }}" alt="Avatar Hombre" class="h-20 w-20 object-cover rounded-full">
        @endif
        @endif
    </td>

    <td class="border px-4 py-2">{{ $personal->nombre }}</td>


    <td class="border px-2 py-2">
        @php
        $especialidad = $personal->especialidad;
        @endphp
        {{ $especialidad ? $especialidad->descripcion : 'Sin especialidad' }}
    </td>
    <td class="border px-4 py-2">{{ $personal->sueldo }} Bs.</td>
    <td class="border px-4 py-2">
        <a href="{{ route('Personal.edit', $personal->id) }}" class="text-blue-600 hover:text-gray-800">
            Editar
        </a>
        <form action="{{ route('Personal.baja', $personal->id) }}" method="POST">
            @csrf
            @method('PUT')
            <button type="submit" class="{{ $personal->baja === 1 ? 'text-red-600 hover:text-red-200' : 'text-green-400 hover:text-green-200' }} ">
                @if($personal->baja === 1)
                De baja
                @else
                Activo
                @endif
            </button>
        </form>
        <form action="{{ route('Personal.destroy', $personal->id) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-600 hover:text-red-800">
                Eliminar
            </button>
        </form>
    </td>
</tr>
@endif
@endforeach