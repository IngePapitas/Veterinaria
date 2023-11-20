@include('nav-welcome')
<style>
    .font-bold {
        font-weight: bold;
    }

    .large-text {
        font-size: 70px;
        font-family: Arial, sans-serif;
    }
</style>
<div class="p-16">

    <h2 class="font-bold text-4xl text-gray-900"> Mis Mascotas</h2>
    @foreach($pacientes as $paciente)
    <div class="mt-8 w-full bg-white border-gray-200 dark:bg-gray-900 rounded-2xl shadow-2xl p-4 grid grid-cols-6 gap-2">
        <img src="{{ Storage::url($paciente->imagen_path) }}" alt="{{ $paciente->nombre }}" class="h-40 w-40 object-cover rounded-xl shadow-lg">
        <div class="h-40 w-40 object-cover rounded-xl shadow-lg ml-4 col-span-2">
            <p class="text-white large-text">{{$paciente->nombre}}</p>
            <p class="text-sm text-white font-semibold">{{$paciente->especie}}</p>
            <p class="text-sm text-white ">{{$paciente->raza}}</p>
        </div>

        @php
            $cita = App\Models\Cita::getCitaAnterior($paciente->id);
            $reprogramarBtnId = 'reprogramarBtn_' . $paciente->id;
            $reprogramarFormId = 'reprogramarForm_' . $paciente->id;
            $nuevafechaid = 'nuevaFecha_'. $paciente->id; 
            $nuevahoraid = 'nuevaHora_'. $paciente->id; 
        @endphp

        @if($cita)
            <div class="bg-white rounded-2xl col-span-2 m-4 p-4">
                <p class="text-sm text-gray-900 font-semibold">Tiene una cita agendada para: {{$cita->fecha}}</p>
                <p class="text-sm text-gray-900 font-semibold">A las: {{$cita->hora}}</p>
                <p class="text-sm text-gray-900 font-semibold">Con el doctor: {{$cita->personal}}</p>
                <button id="{{ $reprogramarBtnId }}" class="bg-blue-500 text-white font-bold py-2 px-4 rounded-full mt-2">
                    Reprogramar
                </button>

                
            </div>
            <form id="{{ $reprogramarFormId }}" class="hidden bg-white rounded-2xl p-4">
                    <!-- Agrega los campos de fecha y hora y cualquier otro que necesites -->
                    <input type="date" id="{{ $nuevafechaid }}" name="nuevaFecha" class="mb-2 rounded-xl" required>
                    <input type="time" id="{{ $nuevahoraid }}" name="nuevaHora" class="mb-2 rounded-xl" required>

                    <button type="submit" class="bg-green-500 text-white font-bold py-2 px-4 rounded-full">
                        Guardar
                    </button>
                </form>
        @endif
    </div>
@endforeach

</div>

<script>
        document.addEventListener('DOMContentLoaded', function () {
            @foreach($pacientes as $paciente)
                const reprogramarBtn_{{ $paciente->id }} = document.getElementById('reprogramarBtn_{{ $paciente->id }}');
                const reprogramarForm_{{ $paciente->id }} = document.getElementById('reprogramarForm_{{ $paciente->id }}');

                reprogramarBtn_{{ $paciente->id }}.addEventListener('click', function () {
                    reprogramarForm_{{ $paciente->id }}.classList.toggle('hidden');
                });

                reprogramarForm_{{ $paciente->id }}.addEventListener('submit', function (event) {
                    event.preventDefault();
                    // Agrega aquí la lógica para procesar el formulario y redirigir según tus necesidades
                    const nuevaFecha_{{ $paciente->id }} = document.getElementById('nuevaFecha_{{ $paciente->id }}').value;
                    const nuevaHora_{{ $paciente->id }} = document.getElementById('nuevaHora_{{ $paciente->id }}').value;

                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = "{{ route('reprogramar', ['pacienteId' => $paciente->id]) }}";

                    const csrfField = document.createElement('input');
                    csrfField.type = 'hidden';
                    csrfField.name = '_token';
                    csrfField.value = "{{ csrf_token() }}";

                    const nuevaFechaField = document.createElement('input');
                    nuevaFechaField.type = 'hidden';
                    nuevaFechaField.name = 'nuevaFecha';
                    nuevaFechaField.value = nuevaFecha_{{ $paciente->id }};

                    const nuevaHoraField = document.createElement('input');
                    nuevaHoraField.type = 'hidden';
                    nuevaHoraField.name = 'nuevaHora';
                    nuevaHoraField.value = nuevaHora_{{ $paciente->id }} ;

                    form.appendChild(csrfField);
                    form.appendChild(nuevaFechaField);
                    form.appendChild(nuevaHoraField);

                    // Agrega el formulario al documento y envíalo
                    document.body.appendChild(form);
                    form.submit();
                    //window.location.href = "{{ route('reprogramar', ['pacienteId' => $paciente->id]) }}" + '?nuevaFecha=' + nuevaFecha_{{ $paciente->id }} + '&nuevaHora=' + nuevaHora_{{ $paciente->id }};
                });
            @endforeach
        });
    </script>