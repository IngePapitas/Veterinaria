@extends('Panza')

@section('Panza')
    <div class="mb-4">
        <a href="{{ route('calendario.index') }}" class="bg-blue-500 hover:bg-blue-600 m-4 text-white font-bold py-2 px-4 rounded">
            Calendario
        </a>
        <!-- Puedes agregar enlaces a otras secciones si es necesario -->
    </div>

    <div class="grid grid-cols-1 gap-1">
        <div class="w-3/5 lg:w-2/4 mx-auto mb-4">
            <h2 class="text-2xl font-bold text-black my-4 ml-4">Actividades y Eventos</h2>
            <form action="{{ route('calendario.store') }}" method="POST" enctype="multipart/form-data"
                class="bg-white shadow-md rounded px-5 pt-6 pb-8 mb-4">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="evento">Nombre Evento:</label>
                    <input type="text" name="evento" id="evento"
                        class="border border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-green-500">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="start_date">Fecha de Inicio:</label>
                    <input type="datetime-local" name="start_date" id="start_date"
                        class="border border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-green-500">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="end_date">Fecha de Fin:</label>
                    <input type="datetime-local" name="end_date" id="end_date"
                        class="border border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-green-500">
                </div>

                <div class="flex items-center justify-between mb-4">
                    <button type="submit"
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Guardar</button>
                    
                    <a href="{{ route('calendario.vercalendario') }}" class="bg-red-500 hover:bg-red-600 m-4 text-white font-bold py-2 px-4 rounded m-auto">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection


