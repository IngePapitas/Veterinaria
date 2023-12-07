@extends('Panza')

@section('Panza')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h2 class="text-2xl font-semibold text-gray-900">Valoraciones</h2>
    <div class="mt-4">
        <div class="shadow overflow-hidden rounded border-b border-gray-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valoración</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID del Servicio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de Creación</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($valoraciones as $valoracion)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $valoracion->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $valoracion->valoracion }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $valoracion->id_nota }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $valoracion->created_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection