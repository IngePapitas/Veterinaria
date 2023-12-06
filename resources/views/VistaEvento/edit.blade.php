@extends('Panza')

@section('Panza')
    <div class="w-full lg:w-1/2 mx-auto my-4">
        <h2 class="text-2xl font-bold text-black mt-8 mb-4 ml-4 uppercase">Actualizar Evento:</h2>
        <form action="{{ route('calendario.update', $evento->id) }}" method="POST" enctype="multipart/form-data"
            class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="evento">Nombre Evento:</label>
                <input type="text" name="evento" id="evento" required value="{{ $evento->event }}"
                    class="border border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-green-500">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="start_date">Fecha de Inicio:</label>
                <input type="datetime-local" name="start_date" id="start_date" required
                    value="{{ \Carbon\Carbon::parse($evento->start_date)->format('Y-m-d\TH:i') }}"
                    class="border border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-green-500">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="end_date">Fecha de Fin:</label>
                <input type="datetime-local" name="end_date" id="end_date" required
                    value="{{ \Carbon\Carbon::parse($evento->end_date)->format('Y-m-d\TH:i') }}"
                    class="border border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-green-500">
            </div>

            <div class="flex items-center justify-between mb-4">
                <button type="submit"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-2">Actualizar</button>
                <a href="{{ route('calendario.create') }}"
                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
