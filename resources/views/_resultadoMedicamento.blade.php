            @foreach ($medicamentos as $medicamento)
                <td class="border px-4 py-2 ">{{ $medicamento->id }}</td>
                <td class="border px-4 py-2 ">{{ $medicamento->nombre }}</td>
                <td class="border px-4 py-2 ">{{ $medicamento->forma_farmaceutica }}</td>
                <td class="border px-4 py-2 ">{{ $medicamento->dosis }}</td>
                <td class="border px-4 py-2 ">{{ $medicamento->stock }}</td>
                <td class="border px-2 py-2">
                    @php
                    $categoriaMedicamento = $medicamento->categoriaMedicamento;
                    @endphp
                    {{ $categoriaMedicamento ? $categoriaMedicamento->nombre : 'Sin Categoria' }}
                </td>
                <td class="border px-2 py-2">
                    @php
                    $laboratorio = $medicamento->laboratorio;
                    @endphp
                    {{ $laboratorio ? $laboratorio->nombre : 'Sin laboratorio' }}
                </td>
                <td class="border px-4 py-2">
                    <a href="{{ route('Medicamento.edit', $medicamento->id) }}" class="text-blue-600 hover:text-gray-800">
                        Editar
                    </a>
                    <form action="{{ route('Medicamento.destroy', $medicamento->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800">
                            Eliminar
                        </button>
                    </form>
                </td>
            @endforeach