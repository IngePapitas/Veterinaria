@extends('Panza')

@section('Panza')
    @php
        use Carbon\Carbon;
    @endphp

    <div id="contenido-a-imprimir" class="container mx-auto mt-8">
        <div class="max-w-3xl mx-auto">
            <div class="flex justify-start my-4">

            </div>
            <div class="overflow-x-auto">

                <div class="container mx-auto p-4">
                    <h2 class="text-2xl font-bold mb-4">Nota de Compra</h2>

                    <div class="bg-white shadow-md rounded px-8 py-6 mb-4">
                        <p class="text-gray-700"><strong>VETLINK</strong></p>
                        <p class="text-gray-700"><strong>Fecha:</strong> {{ Carbon::parse($compras[0]['fecha'])->format('d/m/Y') }}
                        </p>

                        <!-- Aquí puedes añadir más detalles de la venta -->
                    </div>

                    <div class="container mx-auto px-4">
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-200">
                                <thead>
                                    <tr>
                                        <th class="bg-gray-100 text-left px-6 py-3">Item</th>
                                        <th class="bg-gray-100 text-left px-6 py-3">Cantidad</th>
                                        <th class="bg-gray-100 text-left px-6 py-3">Descripción</th>
                                        <th class="bg-gray-100 text-left px-6 py-3">Proveedor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($compras as $compra)
                                    {{-- @dd($venta) --}}
                                    <tr>
                                        <td class="border-t px-6 py-4">{{ $compra['contador']}}</td>
                                        <td class="border-t px-6 py-4">{{ $compra['cantidad']}}</td>
                                        <td class="border-t px-6 py-4">


                                        <p class="font-semibold text-left">{{ $compra['producto_nombre'] }}</p>
                                        <p class="text-xs text-left">Descripción: {{ $compra['producto_descripcion'] }}</p>
                                        <p class="text-xs text-left"></p>
                                        </td>
                                        <td class="border-t px-6 py-4">{{ $compra['proveedor'] }}</td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div>
                        <button onclick="imprimirContenido()"
                            class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Imprimir
                        </button>
                        {{-- <button onclick="window.print()" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Imprimir
                        </button> --}}
                    </div>
                </div>

            </div>
        </div>
    </div>

    
@endsection

<script>
    function generarContenidoImprimible() {
        var contenidoImprimible = `
            <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px;">
                <h2 style="text-align: center; margin-bottom: 20px;">Nota de Compra</h2>
                <p style="font-weight: bold;">VETLINK</p>
                <p>Fecha: {{ Carbon::parse($compras[0]['fecha'])->format('d/m/Y') }}</p>
                <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                    <thead>
                        <tr style="background-color: #f2f2f2;">
                            <th style="padding: 8px; text-align: left;">Item</th>
                            <th style="padding: 8px; text-align: left;">Cantidad</th>
                            <th style="padding: 8px; text-align: left;">Descripción</th>
                            <th style="padding: 8px; text-align: left;">Proveedor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($compras as $compra)
                        <tr>
                            <td style="border: 1px solid #ccc; padding: 8px;">{{ $compra['contador']}}</td>
                            <td style="border: 1px solid #ccc; padding: 8px;">{{ $compra['cantidad']}}</td>
                            <td style="border: 1px solid #ccc; padding: 8px;">
                                <p style="font-weight: bold;">{{ $compra['producto_nombre'] }}</p>
                                <p style="font-size: 12px;">Descripción: {{ $compra['producto_descripcion'] }}</p>
                            </td>
                            <td style="border: 1px solid #ccc; padding: 8px;">{{ $compra['proveedor'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        `;
        return contenidoImprimible;
    }

    function imprimirContenido() {
        var contenido = generarContenidoImprimible();
        var ventana = window.open("", "_blank");
        var contenidoHTML = `
            <html>
                <head>
                    <title>Nota de Compra</title>
                </head>
                <body>
                    ${contenido}
                </body>
            </html>
        `;
        ventana.document.write(contenidoHTML);
        ventana.document.close();
        ventana.print();
        ventana.close();
    }
</script>