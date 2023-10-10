@extends('Panza')

@section('Panza')
<form action="{{ route('Medicamento.update', $medicamento->id) }}" method="POST" class="flex mt-4 overflow-hidden" enctype="multipart/form-data">
    @csrf
    @method('PUT') <!-- Método HTTP PUT para la actualización -->

    <div class="w-3/4 h-auto bg-blue-200 p-8">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold mb-8">Editar Informacion de Medicamento</h2>
            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="nombre" class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{$medicamento->nombre}}" required>
                </div>

                <div class="mb-4">
                    <label for="descripcion" class="block text-gray-700 text-sm font-bold mb-2">Descripción:</label>
                    <input type="text" name="descripcion" id="descripcion" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{$medicamento->descripcion}}" required>
                </div>

                <div class="mb-4">
                    <label for="forma_farmaceutica" class="block text-gray-700 text-sm font-bold mb-2">Forma Farmacéutica:</label>
                    <input type="text" name="forma_farmaceutica" id="forma_farmaceutica" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{$medicamento->forma_farmaceutica}}" required>
                </div>

                <div class="mb-4">
                    <label for="dosis" class="block text-gray-700 text-sm font-bold mb-2">Dosis:</label>
                    <input type="text" name="dosis" id="dosis" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{$medicamento->dosis}}" required>
                </div>

                <div class="mb-4">
                    <label for="precio" class="block text-gray-700 text-sm font-bold mb-2">Precio:</label>
                    <input type="number" name="precio" id="precio" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{$medicamento->precio}}" required>
                </div>

                <div class="mb-4">
                    <label for="stock" class="block text-gray-700 text-sm font-bold mb-2">Stock:</label>
                    <input type="number" name="stock" id="stock" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{$medicamento->stock}}" required>
                </div>

                <div class="mb-4">
                    <label for="laboratorio" class="block text-gray-700 text-sm font-bold mb-2">Laboratorio:</label>
                    <div class="mr-4 flex items-center relative">
                        <input type="text" name="laboratorio" id="laboratorio" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{$medicamento->laboratorio->nombre }}" required>
                        <div id="tablaDiv" class="absolute top-full left-0 bg-yellow-100 hidden">
                            <table id="tabla-laboratorios" class="table-auto w-full">
                                <tbody>
                                    @include('_resultadoLaboratorios_MedicamentoCreate')
                                    <!--Error en esta linea de codigo-->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="categoriaMedicamento" class="block text-gray-700 text-sm font-bold mb-2">Categoría de Medicamento:</label>
                    <div class="mr-4 flex items-center relative">
                        <input type="text" name="categoriaMedicamento" id="categoriaMedicamento" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{$medicamento->categoriaMedicamento->nombre }}" required>
                        <div id="tablaDiv" class="absolute top-full left-0 bg-yellow-100 hidden">
                            <table id="tabla-categoria-medicamento" class="table-auto w-full">
                                <tbody>
                                    @include('_resultadoCategorias_MedicamentoCreate')
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-span-2 mb-4">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection