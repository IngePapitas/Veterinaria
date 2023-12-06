@extends('Panza')

@section('Panza')
    <div class="mb-4">
        <a href="{{ route('calendario.index') }}" class="bg-blue-500 hover:bg-blue-600 m-4 text-white font-bold py-2 px-4 rounded">
            Calendario
        </a>
        <a href="{{ route('calendario.create') }}" class="bg-green-500 hover:bg-green-600 m-4 text-white font-bold py-2 px-4 rounded m-auto">
            Crear
        </a>
    </div>
    <div class="grid grid-cols-1 gap-1">
        <div class="w-full lg:w-6/6 mx-4 mb-4">
            <h2 class="text-2xl font-bold text-black my-4 ml-4">Actividades y Eventos</h2>
            <div class="overflow-x-auto my-6 shadow-md rounded">
                <table class="min-w-full border border-gray-200 mt-4">
                    <thead>
                        <tr>
                            <th class="bg-gray-100 text-left px-6 py-3">#</th>
                            <th class="bg-gray-100 text-left px-6 py-3">Evento</th>
                            <th class="bg-gray-100 text-left px-6 py-3">Fecha de Inicio</th>
                            <th class="bg-gray-100 text-left px-6 py-3">Fecha de Fin</th>
                            <th class="bg-gray-100 text-left px-6 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($events as $evento)
                            <tr>
                                <td class="text-center py-2 px-4 border-b">
                                    <p class="font-semibold text-left">
                                        {{ $evento->id }}</p>
                                </td>

                                <td class="text-center py-2 px-4 border-b">
                                    <p class="font-semibold text-left">
                                        {{ $evento->event }}
                                    </p>
                                </td>

                                <td class="text-center py-2 px-4 border-b">
                                    <p class="font-semibold text-left">
                                        {{ $evento->start_date }}
                                    </p>
                                </td>

                                <td class="text-center py-2 px-4 border-b">
                                    <p class="font-semibold text-left">
                                        {{ $evento->end_date }}
                                    </p>
                                </td>

                                <td class="text-center py-2 px-4 border-b">
                                    <a href="{{ route('calendario.edit', $evento->id) }}"
                                        class="text-green-500 hover:text-green-700 mr-2">
                                        Editar
                                    </a>
                                    <form action="{{ route('calendario.destroy', $evento->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash"
                                                width="20" height="20" viewBox="0 0 24 24" stroke-width="2.5"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" />
                                                <line x1="4" y1="7" x2="20" y2="7" />
                                                <line x1="10" y1="11" x2="10" y2="17" />
                                                <line x1="14" y1="11" x2="14" y2="17" />
                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <td class="text-center py-2 px-4 border-b">id</td>
                            <td class="text-center py-2 px-4 border-b">event</td>
                            <td class="text-center py-2 px-4 border-b">start_date</td>
                            <td class="text-center py-2 px-4 border-b">end_date</td>
                            <td class="text-center py-2 px-4 border-b">
                                <div class="flex justify-center">
                                    editar
                                </div>
                            </td>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


