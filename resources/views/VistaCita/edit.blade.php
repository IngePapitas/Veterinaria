@extends('Panza')

@section('Panza')
<div class="container mx-auto mt-8">
        <h1 class="text-2xl font-semibold mb-4">Editar Cita</h1>

        <form action="{{ route('Cita.update', $cita->id) }}" method="POST" class="max-w-md mx-auto">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="fecha" class="block text-gray-700 text-sm font-bold mb-2">Fecha:</label>
                <input type="date" id="fecha" name="fecha" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $cita->fecha }}" required>
            </div>

            <div class="mb-4">
                <label for="hora" class="block text-gray-700 text-sm font-bold mb-2">Hora:</label>
                <input type="time" id="hora" name="hora" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $cita->hora }}" required>
            </div>

            <div class="mb-4">
                <label for="id_personal" class="block text-gray-700 text-sm font-bold mb-2">Doctor Asignado:</label>
                <select id="id_personal" name="id_personal" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    @foreach($personals as $personal)
                        <option value="{{ $personal->id }}" {{ $cita->id_personal == $personal->id ? 'selected' : '' }}>
                            {{ $personal->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-full">
                Guardar
            </button>
        </form>
    </div>
@endsection