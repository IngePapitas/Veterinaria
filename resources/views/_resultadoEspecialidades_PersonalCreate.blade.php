@foreach($especialidades as $especialidad)
    <button id="buttonEspecialidad{{ $especialidad->id }}" value="{{ $especialidad->descripcion }}" class="border px-4 py-2 m-2">{{ $especialidad->descripcion }}</button>
@endforeach

