@foreach($citas as $cita)
<tr class="mb-4 shadow-inner rounded-xl ">
    <td class=" px-4 py-2">{{ $cita->id }}</td>
    <td class=" px-4 py-2">{{ $cita->paciente }}</td>
    <td class=" px-4 py-2">{{ $cita->personal }}</td>
    <td class=" px-2 py-2">{{ $cita->fecha }}</td>
    <td class=" px-4 py-2">{{ $cita->hora }}</td>
    <td class=" px-4 py-2">
        @if($cita->estado === '0')
        Pendiente
        @elseif($cita->estado === '1')
        Realizada
        @else
        Atrasada
        @endif
    </td>


    <td class=" px-4 py-2">
        <a href="{{ route('Cita.edit', $cita->id) }}" class="text-blue-600 hover:text-gray-800">
            Editar
        </a>
        <form action="{{ route('Cita.destroy', $cita->id) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-600 hover:text-red-800 ml-2">
                Eliminar
            </button>
        </form>
    </td>

</tr>
@endforeach