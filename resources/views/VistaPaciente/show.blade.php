@extends('Panza')

@section('Panza')
<style>
    .font-bold {
        font-weight: bold;
    }

    .large-text {
        font-size: 100px;
        font-family: Arial, sans-serif;
    }
</style>
<div class="flex mt-4 overflow-hidden">

    <div class="w-full h-auto pt-4 p-16 ">
        <div class="max-w- mx-auto bg-white rounded-lg shadow-md p-8">
            <div class="flex h-auto p-8">
                <div class="w-1/4 h-auto p-4 bg-gray-300 rounded-xl shadow-md">
                    <div class="p-2 bg-white rounded-xl shadow-md">
                        <div class="w-full h-64 bg-blue-300 rounded flex items-center justify-center shadow" id="avatar-container">
                        </div>
                    </div>
                    <div class="text-xl mt-4"> <strong>Informacion </strong></div>
                    <div class="font-small mt-4 "> <strong>Codigo: </strong>{{ $paciente->id }}</div>
                    <div class="font-small "> <strong>Especie: </strong>{{ $paciente->especie }}</div>
                    <div class="font-small "> <strong>Raza: </strong>{{ $paciente->raza }}</div>
                    <div class="font-small "> <strong>Peso: </strong>{{ $paciente->peso }} Kg.</div>
                    <div class="font-small "> <strong>Tamaño: </strong>{{ $paciente->tamano }} cm.</div>
                    <div class="font-small "> <strong>Dueño(s): </strong></div>
                    @foreach($duenos as $dueno)
                    @if($dueno->id_paciente == $paciente->id)
                    <div class="font-small ">
                        {{$dueno->nombre}}
                    </div>
                    @endif
                    @endforeach

                </div>

                <div class="w-3/4 h-auto p-4">
                    <div class="h-64 flex text-center items-center justify-center">
                        <div class="font-bold large-text">{{ $paciente->nombre }}</div>
                    </div>
                    <div class="ml-4  text-xl mt-4">
                        
                        <a class="tab-link bg-white inline-block py-2 px-4  hover:text-blue-400 font-semibold rounded-t" data-tab="tab1" href="#">Historial</a>
                        <a class="tab-link bg-white inline-block py-2 px-4  hover:text-blue-400 font-semibold rounded-t" data-tab="tab2" href="#">Vacunas</a>

                        <div id="tab1" class="bg-white border-l border-r border-b p-4 grid">
                        @foreach($historial as $notaservicio)
                        @php

                        if(in_array($notaservicio->id_estado, [1, 2])){
                        $bgColor = 'bg-green-300';
                        }
                        elseif($notaservicio->id_estado === 3){
                        $bgColor = 'bg-gray-300';
                        }
                        elseif(in_array($notaservicio->id_estado, [4, 5])){
                        $bgColor = 'bg-red-300';
                        }
                        else{
                        $bgColor = '';
                        }

                        @endphp

                        <div class="p-2 mt-2 {{ $bgColor }} rounded-xl shadow">

                            <a href="javascript:void(0);" class="modal-trigger" data-notaservicio-id="{{ $notaservicio->id }}"> <!-- Reemplaza 'url' con la URL real si es necesario -->
                                {{ date('d/m/Y', strtotime($notaservicio->created_at)) }}
                                <small>
                                    {{ strlen($notaservicio->nota_descripcion) > 40 ? substr($notaservicio->nota_descripcion, 0, 40) . '...' : $notaservicio->nota_descripcion }}
                                    <strong>Dr. {{ $notaservicio->personalNombre }}</strong>
                                </small>
                            </a>

                        </div>
                        @endforeach
                        @if($citaPendiente)
                        <div class="p-2 mt-2 bg-yellow-300 rounded-xl text-base shadow">
                            Tiene una cita pendiente para <strong>{{ $citaPendiente->fecha}}</strong> a las <strong>{{$citaPendiente->hora}}</strong> con el doctor <strong>{{$citaPendiente->personal}}</strong>
                        </div>
                        @endif
                        </div>
                        <div id="tab2" class="hidden bg-white border-l border-r border-b p-4 grid">
                            @foreach($vacunas as $vacuna)
                            <div class="p-2 mt-2 bg-yellow-300 rounded-xl text-base shadow">
                                Vacuna para <strong>{{ $vacuna->descripcion}}</strong> el dia <strong>{{$vacuna->fecha}}</strong> a las <strong>{{$vacuna->hora}}</strong> 
                            </div>
                            @endforeach
                        </div>


                        <div id="modal" class="fixed inset-0 hidden overflow-auto">
                            <div class="modal-overlay absolute w-full h-full "></div>
                            <div class="modal-container mx-auto bg-yellow-100 mt-16 p-6 rounded-lg shadow-lg bg-white max-w-md">
                                <div class="modal-content text-left relative">
                                    <div id="modalOptions" class="flex items-center justify-center">
                                        <button id="pdf-modal" class="text-blue-600 hover:text-blue-800 font-bold  top-4 right-4 cursor-pointer mr-2"><i class="fa-solid fa-file-pdf"></i></i></button>
                                        <button id="close-modal" class="text-red-600 hover:text-red-800 font-bold  top-4 right-4 cursor-pointer"><i class="fa-solid fa-rectangle-xmark"></i></button>
                                    </div>

                                    <div id="text-field-1" class="mt-4 "> <strong >Servicio: </strong><span id="texto-fecha">Texto inicial</span></div>  
                                    <div id="text-field-personal" class="font-bold text-base"><span id="texto-personal">Texto inicial</span></div>
                                    <div id="text-field-cliente" class="font-bold text-base"><span id="texto-cliente">Texto inicial</span></div>
                                    <div id="text-field-2" class=" text-sm"> <strong>id: </strong><span id="texto-id">Texto inicial</span></div>
                                    <div id="text-field-3" class="mt-4 "> <strong class="text-base">Servicios realizados: </strong></div>
                                    <div id="text-field-4" class="text-sm"> <span id="texto-servicios"></span></div>
                                    <div id="text-field-5" class="mt-4 "> <strong class="text-base">Medicamentos recetados: </strong></div>
                                    <div id="text-field-6" class=" text-sm"> <span id="texto-medicamentos"></span></div>
                                    <div id="text-field-descripcion" class="mt-4 "> <strong class="text-base">Descripcion: </strong></div>
                                    <div id="text-field-descripcion1" class=" text-sm"> <span id="texto-descripcion"></span></div>
                                    <div id="text-field-estado" class="mt-6 "> <strong >Estado del paciente: </strong><span id="texto-estado">Texto inicial</span></div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<input type="hidden" name="imagenpath" id="imagenpath" value="{{ $paciente->imagen_path }}">

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const imagenpathInput = document.getElementById('imagenpath');
        const avatarContainer = document.getElementById('avatar-container');

        const modalTriggerElements = document.querySelectorAll('.modal-trigger');
        const modal = document.getElementById('modal');
        const closeModalButton = document.getElementById('close-modal');
        const allNotaServicios = @json($allNotasServicio);
        const textMedicamentos = document.getElementById('texto-medicamentos');
        const textServicios = document.getElementById('texto-servicios');

        const pathrecortado = imagenpathInput.value.substring(7);
        console.log("path recortado", pathrecortado);
        const imagenPath = "{{ Storage::url('') }}" + pathrecortado;

        console.log(imagenPath);
        if (imagenPath != "/storage/") {
            avatarContainer.style.backgroundSize = '100% 100%';
            avatarContainer.style.backgroundImage = `url('${imagenPath}')`;
        }

        modalTriggerElements.forEach(function(element) {
            element.addEventListener('click', function() {
                const notaservicioId = element.getAttribute('data-notaservicio-id');
                const modalContent = document.querySelector('.modal-content');
                modal.classList.remove('hidden');

                const notaServicioEncontrada = allNotaServicios.find(nota_servicio => nota_servicio.id == notaservicioId);
                const fecha = new Date(notaServicioEncontrada.created_at);
                const options = {
                    year: 'numeric',
                    month: 'numeric',
                    day: 'numeric'
                };
                const fechaFormateada = fecha.toLocaleDateString(undefined, options);

                const textfecha = document.getElementById('texto-fecha');
                textfecha.textContent = fechaFormateada;

                const textid = document.getElementById('texto-id');
                textid.textContent = notaServicioEncontrada.id;

                const textPersonal = document.getElementById('texto-personal');
                textPersonal.textContent = 'Dr. '+ notaServicioEncontrada.personal;

                const textCliente = document.getElementById('texto-cliente');
                textCliente.textContent = 'Cliente: '+ notaServicioEncontrada.cliente + ' (' + notaServicioEncontrada.clienteci + ')';

                const textdescripcion= document.getElementById('texto-descripcion');
                textdescripcion.textContent = notaServicioEncontrada.descripcion;

                const textEstado= document.getElementById('texto-estado');
                textEstado.textContent = notaServicioEncontrada.estado;

                fetch(`/buscar-servicios-pacienteshow?id=${notaservicioId}`)
                    .then(response => response.json())
                    .then(data => {

                        data.forEach(item => {
                            const linea = document.createElement('div');
                            linea.classList.add('grid');
                            linea.classList.add('grid-cols-3');

                            const descripcionServio = document.createElement('div');
                            descripcionServio.textContent = item.descripcion;
                            linea.appendChild(descripcionServio);

                            const precioServio = document.createElement('div');
                            precioServio.textContent = item.precio + ' Bs.';
                            linea.appendChild(precioServio);

                            textServicios.appendChild(linea);
                        });
                    })
                    .catch(error => {

                    });
                fetch(`/buscar-medicamentos-pacienteshow?id=${notaservicioId}`)
                    .then(response => response.json())
                    .then(data => {

                        data.forEach(item => {
                            const linea = document.createElement('div');
                            linea.classList.add('grid');
                            linea.classList.add('grid-cols-3');

                            const nombreMedicamento = document.createElement('div');
                            nombreMedicamento.textContent = item.nombre;
                            linea.appendChild(nombreMedicamento);

                            const cantidadMedicamento = document.createElement('div');
                            cantidadMedicamento.textContent = item.cantidad + ' ' + item.forma_farmaceutica + '(s)';
                            linea.appendChild(cantidadMedicamento);

                            const subtotalMedicamento = document.createElement('div');
                            subtotalMedicamento.textContent = item.subtotal + ' Bs.';
                            linea.appendChild(subtotalMedicamento);

                            textMedicamentos.appendChild(linea);
                        });

                    })
                    .catch(error => {

                    });
            });

            closeModalButton.addEventListener('click', function() {
                modal.classList.add('hidden');
                textServicios.textContent = '';
                textMedicamentos.textContent = '';
            });


        });
        document.querySelectorAll('.tab-link').forEach(tab => {
            tab.addEventListener('click', (e) => {
                e.preventDefault();
                const target = tab.getAttribute('data-tab');

                document.querySelectorAll('div[id^="tab"]').forEach(content => {
                    content.classList.add('hidden');
                });
                document.getElementById(target).classList.remove('hidden');
                document.querySelectorAll('a').forEach(tabItem => {
                    tabItem.classList.remove('selected');
                });
                tab.classList.add('selected');
            });
        });
    });
</script>

@endsection