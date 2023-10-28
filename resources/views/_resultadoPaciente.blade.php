@foreach($pacientes as $paciente)
<tr>
    <td class="border px-4 py-2">{{ $paciente->id }}</td>
    <td class="border px-4 py-2">
        @if($paciente->imagen_path)
        <img src="{{ Storage::url($paciente->imagen_path) }}" alt="{{ $paciente->nombre }}" class="h-20 w-20 object-cover rounded-full">
        @else
        @if($paciente->especie_imagen)
        <img src="{{ Storage::url($paciente->especie_imagen) }}" alt="{{ $paciente->nombre }}" class="h-20 w-20 object-cover rounded-full">
        @else
        <img src="{{ Storage::url('AvataresPacientes/can.jpg') }}" alt="{{ $paciente->nombre }}" class="h-20 w-20 object-cover rounded-full">
        @endif
        @endif
    </td>
    <td class="border px-4 py-2">{{ $paciente->nombre }}</td>
    <td class="border px-2 py-2">{{ $paciente->peso }}</td>
    <td class="border px-4 py-2">{{ $paciente->tamano }}</td>
    <td class="border px-4 py-2">{{ $paciente->especie }}</td>
    <td class="border px-4 py-2">{{ $paciente->raza }}</td>
    <td class="border px-4 py-2">
        <a href="{{ route('Paciente.show', $paciente->id) }}" class="text-blue-600 hover:text-gray-800 mr-2">
            Ver Detalles
        </a>
        <a href="{{ route('Paciente.edit', $paciente->id) }}" class="text-blue-600 hover:text-gray-800 mr-2">
            Editar
        </a>
        <form action="{{ route('Paciente.destroy', $paciente->id) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-600 hover:text-red-800">
                Eliminar
            </button>
        </form>
    </td>
</tr>
@endforeach