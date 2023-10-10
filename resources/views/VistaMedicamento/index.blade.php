@extends('Panza')

@section('Panza')
<div class="container mx-auto px-4 py-8">

    <div class="mb-4">
        <a href="{{ route('Medicamento.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
            Registrar Medicamento
        </a>
    </div>

    <div class="mb-4">
        <label for="ordenar" class="block text-gray-700">Ordenar por:</label>
        <select id="ordenar" class="form-select mt-1 block w-full">
            <option value="id">ID (por defecto)</option>
            <option value="forma_farmaceutica">Forma Farmaceutica</option> 
            <option value="categoria">Categoria</option>
            <option value="laboratorio">Laboratorio</option>
        </select>
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
            @include('_resultadoMedicamento')
        </tbody>
    </table>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const ordenarSelect = document.getElementById('ordenar');
        const tablaMuestra = document.getElementById('tabla-muestra').querySelector('tbody');
        
        ordenarSelect.addEventListener('change', () => {
            const valorSeleccionado = ordenarSelect.value;
            ordenarTabla(valorSeleccionado);
        });

        function ordenarTabla(campo) {
            const filas = Array.from(tablaMuestra.querySelectorAll('tr'));

            filas.sort((a, b) => {
                const valorA = obtenerValorCampo(a, campo);
                const valorB = obtenerValorCampo(b, campo);

                if (campo === 'id') {
                    return parseInt(valorA) - parseInt(valorB);
                } else {
                    return valorA.localeCompare(valorB);
                }
            });

            limpiarTabla();
            filas.forEach(fila => tablaMuestra.appendChild(fila));
        }

        function obtenerValorCampo(fila, campo) {
            const cell = fila.querySelector(`.border-px-4-py-2-${campo}`);
            return cell.textContent.trim();
        }

        function limpiarTabla() {
            while (tablaMuestra.firstChild) {
                tablaMuestra.removeChild(tablaMuestra.firstChild);
            }
        }
    });
</script>
@endsection