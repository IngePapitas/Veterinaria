@extends('Panza')

@section('Panza')

<style>
    a.selected {
        border-left: 1px solid;
        border-top: 1px solid;
        border-right: 1px solid;
    }

    .btn-fixed-right-bottom {
        position: fixed;
        bottom: 20px;
        right: 20px;
    }
</style>
<form action="{{ route('NotaServicio.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="p-4">
        <ul class="flex border-b">
            <li class="-mb-px mr-1">
                <a class="tab-link bg-white inline-block rounded-t py-2 px-4 text-blue-700 font-semibold selected" data-tab="tab1" href="#">Servicio</a>
            </li>
            <li class="mr-1">
                <a class="tab-link bg-white inline-block py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold rounded-t" data-tab="tab2" href="#">Cliente</a>
            </li>
            <li class="mr-1">
                <a class="tab-link bg-white inline-block py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold rounded-t" data-tab="tab3" href="#">Paciente</a>
            </li>
        </ul>
        <!-- TAB SERVICIO -->
        <div id="tab1" class="bg-white border-l border-r border-b p-4 grid">
            <div class="flex h-64 ">
                <div class="w-1/2 h-auto p-4">
                    <div class="mb-4">
                        <label for="servicioInput" class="block text-gray-700 text-sm font-bold mb-2">Servicio:</label>
                        <div class="flex items-center relative">

                            <input type="text" name="servicioInput" id="servicioInput" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <div id="tablaServiciosDiv" class="absolute top-full left-0 bg-yellow-100 hidden">
                                <table id="tabla-servicios" class="table-auto w-full">
                                    <tbody>
                                        @include('_resultadoServicios_CreateNS')
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="w-1/2 h-auto border-l">
                    <!-- SERVICIOS ANADIDOS -->

                    <div id="tablaServiciosSeleccionadosDiv" class="items-center justify-center">
                        <span class="text-gray-700 text-sm font-bold m-8">Servicios Seleccionados</span>
                        <table id="tablaServiciosSeleccionados" class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Servicio</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Precio</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
            <div class="flex border-t h-64">
                <div class="w-1/2 h-auto p-4 ">
                    <div class="mb-4">
                        <label for="medicamentoInput" class="block text-gray-700 text-sm font-bold mb-2">Medicamento:</label>
                        <div class="flex items-center relative">

                            <input type="text" name="medicamentoInput" id="medicamentoInput" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <div id="tablaMedicamentosDiv" class="absolute top-full left-0 bg-yellow-100 hidden">
                                <table id="tabla-medicamentos" class="table-auto w-full">
                                    <tbody>
                                        @include('_resultadoMedicamentos_CreateNS')
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="w-1/2 h-auto border-l p-4">
                    <!-- MEDICAMENTOS ANADIDOS -->

                    <div id="tablaMedicamentosSeleccionadosDiv" class="items-center justify-center">
                        <span class="text-gray-700 text-sm font-bold m-8">Medicamentos Seleccionados</span>
                        <span class="text-red-500 text-sm font-bold m-8 hidden" id="stockInsuficienteSpan">Stock insuficiente!</span>
                        <span class="text-red-500 text-sm font-bold m-8 hidden" id="stockInvalidoSpan">Cantidad invalida!</span>
                        <span class="text-red-500 text-sm font-bold m-8 hidden" id="medicamentoYaSeleccionadoSpan">Medicamento ya seleccionado!</span>
                        <table id="tablaMedicamentosSeleccionados" class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Medicamento</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Cantidad</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Precio</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
            <div class="flex border-t h-64">
                <div class="w-1/2 h-auto p-4 ">
                    <div class="mb-4">
                        <label for="personal" class="block text-gray-700 text-sm font-bold mb-2">Personal responsable:</label>
                        <select name="personal" id="personal" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            @foreach($personals as $personal)
                            <option value="{{ $personal->id }}">{{ $personal->nombre }} - {{ $personal->especialidad }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-32 ">
                        <div class="text-green-500 text-4xl font-bold" id="divTotal">Total: <span class="text-green-500 text-4xl font-bold" id="spanTotal"></span></div>
                    </div>
                </div>
                <div class="w-1/2 h-auto p-4 ">
                    <label for="descripcionServicio" class="block text-gray-700 text-sm font-bold mb-2">Notas: </label>
                    <textarea id="descripcionServicio" name="descripcionServicio" class="w-full p-2 border rounded" rows="5"></textarea>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-4 px-8 rounded text-2xl">
                            Guardar Nota de Servicio
                        </button>
                    </div>
                </div>
            </div>

        </div>


        <!-- TAB CLIENTE -->
        <div id="tab2" class="hidden bg-white border-l border-r border-b p-4">
            <div class="mb-4">
                <label for="ci_cliente" class="block text-gray-700">CI:</label>
                <input type="text" name="ci_cliente" id="ci_cliente" class="form-input mt-1 w-full">
            </div>

            <div class="mb-4">
                <label for="nombre_cliente" class="block text-gray-700">Nombre:</label>
                <input type="text" name="nombre_cliente" id="nombre_cliente" class="form-input mt-1 w-full">
            </div>

            <div class="mb-4">
                <label for="correo_cliente" class="block text-gray-700">Correo:</label>
                <input type="email" name="correo_cliente" id="correo_cliente" class="form-input mt-1 w-full">
            </div>

            <div class="mb-4">
                <label for="telefono_cliente" class="block text-gray-700">Teléfono:</label>
                <input type="text" name="telefono_cliente" id="telefono_cliente" class="form-input mt-1 w-full">
            </div>
        </div>

        <!-- TAB PACIENTE -->
        <div id="tab3" class="hidden bg-white border-l border-r border-b p-4">
            <div class="flex mt-4 overflow-hidden">
                <div class="w-1/4 h-screen ">
                    <div class="w-full bg-blue-300 flex items-center justify-center" id="avatar-container" style="padding-bottom: 100%;">
                        <button id="eliminarImagenBtn" type="button" class="hidden  bg-red-500 text-white font-semibold py-1 px-2 rounded">
                            Eliminar Imagen
                        </button>
                    </div>
                    <div class="mb-4 flex items-center justify-center my-4">
                        <input type="file" name="imagen" id="cargarImagen" accept="image/*" class="hidden">
                        <label for="cargarImagen" class="cursor-pointer bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Cargar imagen
                        </label>
                    </div>


                </div>
                <div class="w-3/4 h-screen  p-16">

                    <div class="mb-4">
                        <label for="codigo" class="block text-gray-700 text-sm font-bold mb-2">Codigo:</label>
                        <input type="text" name="codigo" id="codigo" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>

                    <div class="mb-4">
                        <label for="nombre" class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>

                    <div class="mb-4">
                        <label for="peso" class="block text-gray-700 text-sm font-bold mb-2">Peso(Kg):</label>
                        <input type="text" name="peso" id="peso" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>

                    <div class="mb-4">
                        <label for="tamano" class="block text-gray-700 text-sm font-bold mb-2">Tamaño(cm):</label>
                        <input type="text" name="tamano" id="tamano" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>

                    <div class="mb-4">
                        <label for="especie" class="block text-gray-700 text-sm font-bold mb-2">Especie:</label>
                        <div class="mr-4 flex items-center relative">
                            <input type="text" name="especie" id="especie" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            <div id="tablaEspeciesDiv" class="absolute top-full left-0 bg-yellow-100 hidden">
                                <table id="tabla-especies" class="table-auto w-full">
                                    <tbody>
                                        @include('_resultadoEspecie_PacienteCreate')
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="raza" class="block text-gray-700 text-sm font-bold mb-2">Raza:</label>
                        <div class="mr-4 flex items-center relative">
                            <input type="text" name="raza" id="raza" class="w-full border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            <div id="tablaRazasDiv" class="absolute top-full left-0 bg-yellow-100 hidden">
                                <table id="tabla-razas" class="table-auto w-full">
                                    <tbody>
                                        @include('_resultadoRaza_PacienteCreate')
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="imagen_cargada" id="imagenCargadaInput">
                    <input type="hidden" name="InputServicios" id="InputServicios">
                    <input type="hidden" name="InputMedicamentos" id="InputMedicamentos">
                    <input type="hidden" name="InputCantidades" id="InputCantidades">
                </div>
            </div>
        </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        //CONSTANTES CLIENTES
        const ci_cliente = document.getElementById('ci_cliente');
        const nombre_cliente = document.getElementById('nombre_cliente');
        const telefono_cliente = document.getElementById('telefono_cliente');
        const correo_cliente = document.getElementById('correo_cliente');
        const clientes = @json($clientes);

        //CONSTANTES PACIENTES
        const raza = document.getElementById('raza');
        const especie = document.getElementById('especie');
        const tablaEspeciesDiv = document.getElementById('tablaEspeciesDiv');
        const tablaRazaDiv = document.getElementById('tablaRazasDiv');
        const tablaEspecies = document.getElementById('tabla-especies');
        const tablaRaza = document.getElementById('tabla-razas');
        const avatarContainer = document.getElementById('avatar-container');
        const cargarImagenInput = document.getElementById('cargarImagen');
        const imagenCargadaInput = document.getElementById('imagenCargadaInput');
        const peso = document.getElementById('peso');
        const codigo = document.getElementById('codigo');
        const tamano = document.getElementById('tamano');
        let imagenCargada = false;
        const pacientes = @json($pacientes);
        const allEspecies = @json($allEspecies);
        const allRazas = @json($allRazas);

        //CONSTANTES SERVICIOS
        const servicioInput = document.getElementById('servicioInput');
        const tablaServicios = document.getElementById('tabla-servicios');
        const tablaServiciosDiv = document.getElementById('tablaServiciosDiv');
        const serviciosSeleccionados = [];
        const tablaServiciosSelecionadosDiv = document.getElementById('tablaServiciosSeleccionadosDiv');
        const InputServicios = document.getElementById('InputServicios');
        const allServicios = @json($allServicios);

        //MEDICAMENTOS
        const tablaMedicamentosSelecionadosDiv = document.getElementById('tablaMedicamentosSeleccionadosDiv');
        const medicamentoInput = document.getElementById('medicamentoInput');
        const tablaMedicamentos = document.getElementById('tabla-medicamentos');
        const tablaMedicamentosDiv = document.getElementById('tablaMedicamentosDiv');
        const medicamentosSeleccionados = [];
        const cantidadesSeleccionadas = [];
        const InputMedicamentos = document.getElementById('InputMedicamentos');
        const allMedicamentos = @json($allMedicamentos);
        const InputCantidades = document.getElementById('InputCantidades');

        const spanTotal = document.getElementById('spanTotal');
        let total = 0;
        let totalServicios = 0;
        let totalMedicamentos = 0;
        spanTotal.textContent = total + 'Bs.';

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
                actualizarTablaDeServicios();
                actualizarTablaDeMedicamentos();
            });
        });

        ci_cliente.addEventListener('input', () => {
            const textoid = ci_cliente.value.trim();
            console.log(textoid);
            console.log(clientes);

            const clienteencontrado = clientes.find(cliente => cliente.ci === textoid);

            if (clienteencontrado) {
                nombre_cliente.value = clienteencontrado.nombre;
                telefono_cliente.value = clienteencontrado.telefono;
                correo_cliente.value = clienteencontrado.correo;
            } else {
                nombre_cliente.value = '';
                telefono_cliente.value = '';
                correo_cliente.value = '';
            }
        });


        actualizarAvatar();



        cargarImagenInput.addEventListener('change', (event) => {
            const imagenSeleccionada = event.target.files[0];
            if (imagenSeleccionada) {
                const imageUrl = URL.createObjectURL(imagenSeleccionada);
                avatarContainer.style.backgroundImage = `url('${imageUrl}')`;
                imagenCargada = true;
                eliminarImagenBtn.classList.remove('hidden');
            }
        });

        especie.addEventListener('input', () => {
            const texto = especie.value.trim().toLowerCase();
            if (texto === '') {
                tablaEspeciesDiv.classList.add('hidden');
                cargarEspecies('');
            } else {
                tablaEspeciesDiv.classList.remove('hidden');
                cargarEspecies(texto);
            }
        });

        function cargarEspecies(texto) {
            fetch(`/buscar-especies-create?texto=${texto}`)
                .then(response => response.text())
                .then(data => {
                    tablaEspecies.querySelector('tbody').innerHTML = data;
                })
                .catch(error => {
                    console.error('Error al cargar los resultados:', error);
                });
        }

        tablaEspecies.addEventListener('click', (event) => {
            if (event.target.tagName === 'BUTTON') {
                const especieValue = event.target.value;
                console.log('Valor del botón de especialidad:', especieValue);
                const especieInput = document.getElementById('especie');
                especieInput.value = especieValue;
                actualizarAvatar();
                tablaEspeciesDiv.classList.add('hidden');
            }

        });

        raza.addEventListener('input', () => {
            const texto = raza.value.trim().toLowerCase();
            if (texto === '') {
                tablaRazaDiv.classList.add('hidden');
                cargarRazas('');
            } else {
                tablaRazaDiv.classList.remove('hidden');
                cargarRazas(texto);
            }
        });

        function cargarRazas(texto) {
            const especietext = especie.value.trim().toLowerCase();
            fetch(`/buscar-razas-create?texto=${texto}&especie=${especietext}`)
                .then(response => response.text())
                .then(data => {
                    tablaRaza.querySelector('tbody').innerHTML = data;
                })
                .catch(error => {
                    console.error('Error al cargar los resultados razas:', error);
                });
        }

        tablaRaza.addEventListener('click', (event) => {
            if (event.target.tagName === 'BUTTON') {
                const razaValue = event.target.value;
                console.log('Valor del botón de especialidad:', razaValue);
                const razaInput = document.getElementById('raza');
                razaInput.value = razaValue;
                tablaRazaDiv.classList.add('hidden');
            }

        });

        console.log("Avatar ACtualizado");

        function actualizarAvatar() {
            console.log("Avatar Actualizado");
            if (!imagenCargada) {
                eliminarImagenBtn.classList.add('hidden');
                const texto = especie.value.trim().toLowerCase();
                console.log("enviando a la funcion", texto);
                fetch(`/buscar-especie-imagen?texto=${texto}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log("Valor de imagenUrl:", data.imagenUrl);
                        const imagenUrl = data.imagenUrl;
                        const avatarUrl = `{{ asset('storage/${imagenUrl}') }}`;
                        console.log(imagenUrl);
                        avatarContainer.style.backgroundImage = `url('${avatarUrl}')`;
                        avatarContainer.style.backgroundSize = '100% 100%';

                    })
                    .catch(error => {
                        console.error('Error al cargar los imagen:', error);
                    });


            }

        }


        eliminarImagenBtn.addEventListener('click', () => {
            cargarImagenInput.value = '';
            eliminarImagenBtn.classList.add('hidden');
            imagenCargada = false;
            actualizarAvatar();
        });

        function actualizarImagenCargada() {
            const imagenSeleccionada = event.target.files[0];
            if (imagenSeleccionada) {
                const imageUrl = URL.createObjectURL(imagenSeleccionada);
                avatarContainer.style.backgroundImage = `url('${imageUrl}')`;
                imagenCargada = true;
                eliminarImagenBtn.classList.remove('hidden');
            }
        }

        codigo.addEventListener('input', () => {
            const codigotext = codigo.value.trim();
            console.log(codigotext);
            console.log(pacientes);

            const pacienteencontrado = pacientes.find(paciente => paciente.id === parseInt(codigotext));

            if (pacienteencontrado) {
                console.log("encontrado");
                nombre.value = pacienteencontrado.nombre;
                peso.value = pacienteencontrado.peso;
                tamano.value = pacienteencontrado.tamano;

                const especieencontrada = allEspecies.find(especie => especie.id === parseInt(pacienteencontrado.id_especie));
                especie.value = especieencontrada.nombre;

                const razaencontrada = allRazas.find(raza => raza.id === parseInt(pacienteencontrado.id_raza));
                raza.value = razaencontrada.nombre;

                if (pacienteencontrado.imagen_path) {
                    const pathrecortado = pacienteencontrado.imagen_path.substring(7);
                    console.log("path recortado", pathrecortado);
                    const imagenPath = "{{ Storage::url('') }}" + pathrecortado;

                    console.log(imagenPath);
                    if (imagenPath != "/storage/") {
                        avatarContainer.style.backgroundImage = `url('${imagenPath}')`;
                        imagenCargada = true;
                        eliminarImagenBtn.classList.remove('hidden');
                        imagenCargadaInput.value = pacienteencontrado.imagen_path;
                    }
                } else {
                    actualizarAvatar();
                }
            } else {
                nombre.value = '';
                peso.value = '';
                tamano.value = '';
                raza.value = '';
                especie.value = '';
                cargarImagenInput.value = '';
                imagenCargada = false;
                actualizarAvatar();
            }
        });

        //PARTE DE SERVICIO


        tablaServicios.addEventListener('click', (event) => {
            if (event.target.tagName === 'BUTTON') {
                const servicioValue = event.target.value;
                serviciosSeleccionados.push(servicioValue);
                servicioInput.value = '';
                actualizarTablaDeServicios();
                console.log(serviciosSeleccionados);
                tablaServiciosDiv.classList.add('hidden');
            }
        });

        servicioInput.addEventListener('input', () => {
            const texto = servicioInput.value.trim().toLowerCase();
            console.log(texto);
            if (texto === '') {
                tablaServiciosDiv.classList.add('hidden');
                cargarServicios('');
            } else {
                tablaServiciosDiv.classList.remove('hidden');
                cargarServicios(texto);
            }
        });

        function cargarServicios(texto) {
            console.log(texto);
            fetch(`/buscar-servicios-create?texto=${texto}`)
                .then(response => response.text())
                .then(data => {
                    tablaServicios.querySelector('tbody').innerHTML = data;
                })
                .catch(error => {
                    console.error('Error al cargar los resultados:', error);
                });
        }


        function actualizarTablaDeServicios() {
            const tablaServiciosSeleccionados = document.getElementById('tablaServiciosSeleccionados');
            const tbody = tablaServiciosSeleccionados.querySelector('tbody');
            tbody.innerHTML = '';
            totalServicios = 0;

            serviciosSeleccionados.forEach(servicioValue => {

                const row = document.createElement('tr');

                const servicioEncontrado = allServicios.find(servicio => servicio.descripcion == servicioValue);
                console.log(servicioEncontrado);
                const idCell = document.createElement('td');
                idCell.textContent = servicioEncontrado.id;
                idCell.classList.add('text-center');

                const servicioCell = document.createElement('td');
                servicioCell.textContent = servicioValue;
                servicioCell.classList.add('text-center');

                const precioCell = document.createElement('td');
                precioCell.textContent = servicioEncontrado.precio + "Bs.";
                precioCell.classList.add('text-center');
                totalServicios += servicioEncontrado.precio;

                const eliminarCell = document.createElement('td');
                const eliminarBoton = document.createElement('button');
                eliminarBoton.innerHTML = '<i class="fa-solid fa-trash"></i>';
                eliminarCell.classList.add('text-center');
                eliminarCell.classList.add('text-red-500');
                eliminarBoton.addEventListener('click', () => eliminarServicio(servicioValue));
                eliminarCell.appendChild(eliminarBoton);

                row.appendChild(idCell);
                row.appendChild(servicioCell);
                row.appendChild(precioCell);
                row.appendChild(eliminarCell);

                tbody.appendChild(row);
            });

            total = totalMedicamentos + totalServicios;
            spanTotal.textContent = total + 'Bs.';
            InputServicios.value = serviciosSeleccionados;
            tablaServiciosSelecionadosDiv.classList.remove('hidden');
        }


        function eliminarServicio(servicioValue) {
            const indice = serviciosSeleccionados.indexOf(servicioValue);
            if (indice !== -1) {
                serviciosSeleccionados.splice(indice, 1);
                actualizarTablaDeServicios();
            }
        }

        //PARTE MEDICAMENTO

        tablaMedicamentos.addEventListener('click', (event) => {
            if (event.target.tagName === 'BUTTON') {
                const medicamentoValue = event.target.value;
                const medicamentoEncontrado = allMedicamentos.find(medicamento => medicamento.nombre == medicamentoValue);
                console.log(medicamentoEncontrado);
                if (medicamentosSeleccionados.includes(medicamentoEncontrado.descripcion)) {
                    const medicamentoYaSeleccionadoSpan = document.getElementById('medicamentoYaSeleccionadoSpan');
                    medicamentoYaSeleccionadoSpan.classList.remove('hidden');
                    setTimeout(() => {
                        medicamentoYaSeleccionadoSpan.classList.add('hidden');
                    }, 2000);
                } else {
                    if (medicamentoEncontrado.stock > 0) {
                        medicamentosSeleccionados.push(medicamentoValue);
                        cantidadesSeleccionadas.push(1);
                    } else {
                        const stockInsuficienteSpan = document.getElementById('stockInvalidoSpan');
                        stockInsuficienteSpan.classList.remove('hidden');
                        setTimeout(() => {
                            stockInsuficienteSpan.classList.add('hidden');
                        }, 2000);
                    }
                }
                medicamentoInput.value = '';
                actualizarTablaDeMedicamentos();
                console.log(medicamentosSeleccionados);
                tablaMedicamentosDiv.classList.add('hidden');
            }
        });

        medicamentoInput.addEventListener('input', () => {
            const texto = medicamentoInput.value.trim().toLowerCase();
            console.log(texto);
            if (texto === '') {
                tablaMedicamentosDiv.classList.add('hidden');
                cargarMedicamentos('');
            } else {
                tablaMedicamentosDiv.classList.remove('hidden');
                cargarMedicamentos(texto);
            }
        });

        function cargarMedicamentos(texto) {
            console.log(texto);
            fetch(`/buscar-medicamentos-create?texto=${texto}`)
                .then(response => response.text())
                .then(data => {
                    tablaMedicamentos.querySelector('tbody').innerHTML = data;
                })
                .catch(error => {
                    console.error('Error al cargar los resultados:', error);
                });
        }


        function actualizarTablaDeMedicamentos() {
            const tablaMedicamentosSeleccionados = document.getElementById('tablaMedicamentosSeleccionados');
            const tbody = tablaMedicamentosSeleccionados.querySelector('tbody');
            tbody.innerHTML = '';
            totalMedicamentos = 0;

            medicamentosSeleccionados.forEach(medicamentoValue => {
                const row = document.createElement('tr');

                const medicamentoEncontrado = allMedicamentos.find(medicamento => medicamento.nombre == medicamentoValue);
                console.log(medicamentoEncontrado);
                const idCell = document.createElement('td');
                idCell.textContent = medicamentoEncontrado.id;
                idCell.classList.add('text-center');

                const medicamentoCell = document.createElement('td');
                medicamentoCell.textContent = medicamentoValue;
                medicamentoCell.classList.add('text-center');

                const indice = medicamentosSeleccionados.indexOf(medicamentoValue);
                const cantidadCell = document.createElement('td');
                cantidadCell.textContent = cantidadesSeleccionadas[indice];
                cantidadCell.classList.add('text-center');

                const precioCell = document.createElement('td');
                precioCell.textContent = medicamentoEncontrado.precio;
                precioCell.classList.add('text-center');

                totalMedicamentos += medicamentoEncontrado.precio * cantidadesSeleccionadas[indice];

                const eliminarCell = document.createElement('td');
                eliminarCell.classList.add('text-center');

                const eliminarBoton = document.createElement('button');
                eliminarBoton.innerHTML = '<i class="fa-solid fa-trash"></i>';
                eliminarBoton.classList.add('text-red-500');
                eliminarBoton.classList.add('ml-2');

                const anadirBoton = document.createElement('button');
                anadirBoton.innerHTML = '<i class="fa-solid fa-plus"></i>';
                anadirBoton.classList.add('text-blue-500');

                const subBoton = document.createElement('button');
                subBoton.innerHTML = '<i class="fa-solid fa-minus"></i>';
                subBoton.classList.add('text-red-500');
                subBoton.classList.add('ml-2');


                eliminarBoton.addEventListener('click', () => eliminarMedicamento(medicamentoValue));
                anadirBoton.addEventListener('click', () => aumentarCantidadMedicamento(medicamentoValue));
                subBoton.addEventListener('click', () => restarCantidadMedicamento(medicamentoValue));

                eliminarCell.appendChild(anadirBoton);
                eliminarCell.appendChild(subBoton);
                eliminarCell.appendChild(eliminarBoton);


                row.appendChild(idCell);
                row.appendChild(medicamentoCell);
                row.appendChild(cantidadCell);
                row.appendChild(precioCell);
                row.appendChild(eliminarCell);

                tbody.appendChild(row);
            });
            total = totalMedicamentos + totalServicios;
            spanTotal.textContent = total + 'Bs.';

            InputMedicamentos.value = medicamentosSeleccionados;
            InputCantidades.value = cantidadesSeleccionadas;
            tablaMedicamentosSelecionadosDiv.classList.remove('hidden');
        }


        function eliminarMedicamento(medicamentoValue) {
            const indice = medicamentosSeleccionados.indexOf(medicamentoValue);
            if (indice !== -1) {
                medicamentosSeleccionados.splice(indice, 1);
                cantidadesSeleccionadas.splice(indice, 1);
                actualizarTablaDeMedicamentos();
            }
        }

        function aumentarCantidadMedicamento(medicamentoValue) {
            const indice = medicamentosSeleccionados.indexOf(medicamentoValue);
            if (indice !== -1) {
                const verificadorStock = allMedicamentos.find(medicamento => medicamento.nombre == medicamentoValue);
                if (verificadorStock.stock > cantidadesSeleccionadas[indice]) {
                    cantidadesSeleccionadas[indice] = cantidadesSeleccionadas[indice] + 1;
                    actualizarTablaDeMedicamentos();
                } else {
                    const stockInsuficienteSpan = document.getElementById('stockInsuficienteSpan');
                    stockInsuficienteSpan.classList.remove('hidden');
                    setTimeout(() => {
                        stockInsuficienteSpan.classList.add('hidden');
                    }, 2000);
                }
                console.log(cantidadesSeleccionadas);
            }
        }

        function restarCantidadMedicamento(medicamentoValue) {
            const indice = medicamentosSeleccionados.indexOf(medicamentoValue);
            if (indice !== -1) {
                if (cantidadesSeleccionadas[indice] > 1) {
                    cantidadesSeleccionadas[indice] = cantidadesSeleccionadas[indice] - 1;
                    actualizarTablaDeMedicamentos();
                } else {
                    const stockInsuficienteSpan = document.getElementById('stockInvalidoSpan');
                    stockInsuficienteSpan.classList.remove('hidden');
                    setTimeout(() => {
                        stockInsuficienteSpan.classList.add('hidden');
                    }, 2000);
                }
            }
            console.log(cantidadesSeleccionadas);
        }



    });
</script>


@endsection