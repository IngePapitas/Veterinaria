@extends('Panza')

@section('Panza')
<div class="container mx-auto px-4 py-8">

    <div class="mb-4">
        <a href="{{ route('Medicamento.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
            Registrar Medicamento
        </a>
    </div>

    <table id="tabla-muestra" class="table-auto w-full">
        <thead>
            <tr>
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Nombre</th>
                <!-- <th class="px-4 py-2">Descripción</th> -->
                <th class="px-4 py-2">Forma Farmaceutica</th>
                <th class="px-4 py-2">Dosis</th>
                <th class="px-4 py-2">Stock</th>
                <th class="px-4 py-2">Categoria</th>
                <th class="px-4 py-2">Laboratorio</th>
                <th class="px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
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
                    <a href="{{ route('Medicamento.edit', $medicamentos->id) }}" class="text-blue-600 hover:text-gray-800">
                        Editar
                    </a>
                    <form action="{{ route('Medicamento.destroy', $medicamentos->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800">
                            Eliminar
                        </button>
                    </form>
                </td>
            @endforeach
        </tbody>
    </table>
</div>

@endsection