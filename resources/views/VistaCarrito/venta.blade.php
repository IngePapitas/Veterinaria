@include('nav-welcome')

<div class="container mx-auto px-4 mt-8">
    <h1 class="text-3xl font-bold mb-4">Compras Realizadas</h1>

    <div class="w-full overflow-x-auto">
        <table class="w-full border-collapse border border-gray-200">
            <thead>
                <tr>
                    <th class="bg-gray-100 text-left px-6 py-3">No. de Venta</th>
                    <th class="bg-gray-100 text-left px-6 py-3">Artículos</th>
                    <th class="bg-gray-100 text-left px-6 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ventas as $venta)
                <tr>
                    <td class="border-t px-6 py-4">{{ $venta['venta']->id }}</td>
                    <td class="border-t px-6 py-4">
                        <ul class="list-disc ml-6">
                            @foreach ($venta['productos'] as $producto)
                                <li>{{ $producto->producto_nombre }} ({{ $producto->producto_descripcion }})</li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="border-t px-6 py-4">
                        <a href="{{ route('notaVenta', ['id' => $venta['venta']->id]) }}" class="text-blue-500 hover:underline mr-2">Ver Nota</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@include('footer')
