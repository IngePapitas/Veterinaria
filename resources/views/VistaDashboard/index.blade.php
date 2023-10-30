@extends ('Panza')

@section('Panza')
<script>
    function getMonthName(monthNumber) {
        const meses = [
            'Enero',
            'Febrero',
            'Marzo',
            'Abril',
            'Mayo',
            'Junio',
            'Julio',
            'Agosto',
            'Septiembre',
            'Octubre',
            'Noviembre',
            'Diciembre',
        ];

        return meses[monthNumber - 1];
    }
</script>
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Estadísticas de Ingresos por Mes</h1>
    <div class="grid grid-cols-6 gap-4">
        <select id="mesAnioInicioSelect" class="mr-4 p-2 border rounded">
            <option value="" disabled selected>Fecha inicio..</option>
            @php
            $max_year=date('Y');
            $min_year=2023;
            for ($y=$max_year; $y>= $min_year; $y--) {
            $month_start = 12;

            if ($y == $max_year) {
            $month_start = date('m');
            }

            for ($m = $month_start; $m > 0; $m--) {
            echo '<option value="' . $y . '-' . $m . '">' . $y . ' <script>
                    document.write(getMonthName(' . $m . '));
                </script>' . '</option>';
            }
            }
            @endphp
        </select>

        <select id="mesAnioFinalSelect" class="mr-4 p-2 border rounded">
            <option value="" disabled selected>Fecha final..</option>
            @php $max_year=date('Y');
            $min_year=2023;
            for ($y=$max_year; $y>= $min_year; $y--) {
            $month_start = 12;

            if ($y == $max_year) {
            $month_start = date('m');
            }

            for ($m = $month_start; $m > 0; $m--) {
            echo '<option value="' . $y . '-' . $m . '">' . $y . ' <script>
                    document.write(getMonthName(' . $m . '));
                </script>' . '</option>';
            }
            }
            @endphp
        </select>


        <select id="servicioSelect" class="p-2 border rounded">
            <option value="" disabled selected>Serivico..</option>
            <option value="">Todos los servicios</option>
            @foreach ($servicios as $servicio)
            <option value="{{ $servicio->id }}">{{ $servicio->descripcion }}</option>
            @endforeach
        </select>

        <select id="medicamentoSelect" class="p-2 border rounded">
            <option value="" disabled selected>Medicamento..</option>
            <option value="">Todos los medicamentos</option>
            @foreach ($medicamentos as $medicamento)
            <option value="{{ $medicamento->id }}">{{ $medicamento->nombre }}</option>
            @endforeach
        </select>

        <button class="bg-blue-500 text-white p-2 rounded" id="btnFiltro">Generar</button>

        <button class="bg-green-500 text-white p-2 rounded" id="btnExcel"><i class="fa-solid fa-file-excel"></i></button>
    </div>

    <div class="grid grid-cols-2 gap-4 mt-4">
        <div class="bg-white rounded shadow p-4">
            <h2 class="text-xl font-semibold mb-4">Ingresos por servicios</h2>
            <canvas id="ventasPorMes" class="w-full h-16"></canvas>
        </div>

        <div class="bg-white rounded shadow p-4">
            <h2 class="text-xl font-semibold mb-4">Ingresos por medicamentos</h2>
            <canvas id="ventasPorMesMedicamentos" class="w-full h-16"></canvas>
        </div>
    </div>
    <div class="grid grid-cols-2 gap-4 mt-4">
        <div class="bg-white rounded shadow p-4">
            <h2 class="text-xl font-semibold mb-4">Servicios requeridos</h2>
            <canvas id="serviciosRequeridos" class="w-full h-16"></canvas>
        </div>
    </div>
    <div id="modal" class="fixed inset-0 hidden overflow-auto">
        <div class="modal-overlay absolute w-full h-full "></div>
        <div class="modal-container mx-auto bg-blue-100 mt-16 p-6 rounded-lg shadow-lg bg-white max-w-md">
            <div class="modal-content text-left relative">
                <div id="modalOptions" class="flex items-center justify-center">
                    <button id="close-modal" class="text-red-600 hover:text-red-800 font-bold  top-4 right-4 cursor-pointer"><i class="fa-solid fa-rectangle-xmark"></i></button>
                </div>
                <select id="estadisticaSelect" class="p-2 border rounded w-full mt-4">
                    <option value="" disabled selected>Seleccione estadistica..</option>
                    <option value="ingresosServicios">Ingresos Servicios</option>
                    <option value="ingresosMedicamentos">Ingresos Medicamentos</option>
                    <option value="serviciosRequeridos">Servicios Requeridos</option>
                </select>

                <div class="mt-4">
                    <input type="checkbox" id="enviarAAdministradores" name="enviarAAdministradores">
                    <label for="enviarAAdministradores">Enviar a administradores</label>
                </div>
                <div class="flex items-center justify-center mt-4">
                    <button class="bg-white p-2 rounded" id="btnGenerarExcel">Generar</button>
                </div>


            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', () => {

        const ctxServicios = document.getElementById('ventasPorMes').getContext('2d');
        const ctxMedicamentos = document.getElementById('ventasPorMesMedicamentos').getContext('2d');
        const ctxPieServicios = document.getElementById('serviciosRequeridos').getContext('2d');
        const btnFiltro = document.getElementById('btnFiltro');
        const btnExcel = document.getElementById('btnExcel');
        const btnGenerarExcel = document.getElementById('btnGenerarExcel');
        const modalTriggerElements = document.querySelectorAll('.modal-trigger');
        const modal = document.getElementById('modal');
        const closeModalButton = document.getElementById('close-modal');
        const token = document.head.querySelector('meta[name="csrf-token"]').getAttribute('content');

        let graficoPie1;
        let fechaIni = '';
        let fechaFin = '';
        let servicioSel = '';
        let medicamentoSel = '';
        let graficoBarra2;
        let graficoBarra1;
        let excel = false;
        let enviarAdm = false;



        //Datos ventas servicios
        const datosVentas = {
            labels: [],
            datasets: [{
                label: 'Ingresos por Mes',
                data: [],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
            }]
        };
        graficoBarra1 = new Chart(ctxServicios, {
            type: 'bar',
            data: datosVentas,
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    }
                }
            }
        });

        //Datos ventas Medicamentos
        const datosVentasMedicamentos = {
            labels: [],
            datasets: [{
                label: 'Ingresos por Mes',
                data: [],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
            }]
        };
        graficoBarra2 = new Chart(ctxMedicamentos, {
            type: 'bar',
            data: datosVentasMedicamentos,
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    }
                }
            }
        });

        //Datos servicios requeridos
        graficoPie1 = new Chart(ctxPieServicios, {
            type: 'pie',
            data: {
                labels: [],
                datasets: [{
                    data: [],
                    backgroundColor: ['red', 'blue', 'green', 'orange', 'purple'],
                }],
            },
            options: {
                responsive: true,
            }
        });


        getDatosServicios(fechaIni, fechaFin, servicioSel);
        getDatosMedicamentos(fechaIni, fechaFin, medicamentoSel);
        getDatosServiciosRequeridos(fechaIni, fechaFin)


        btnFiltro.addEventListener('click', () => {
            fechaIni = document.getElementById('mesAnioInicioSelect').value;
            fechaFin = document.getElementById('mesAnioFinalSelect').value;
            servicioSel = document.getElementById('servicioSelect').value;
            medicamentoSel = document.getElementById('medicamentoSelect').value;
            getDatosServicios(fechaIni, fechaFin, servicioSel);
            getDatosMedicamentos(fechaIni, fechaFin, medicamentoSel);
            getDatosServiciosRequeridos(fechaIni, fechaFin)
        });

        btnExcel.addEventListener('click', () => {
            const modalContent = document.querySelector('.modal-content');
            modal.classList.remove('hidden');
        });

        closeModalButton.addEventListener('click', function() {
            modal.classList.add('hidden');
        });

        btnGenerarExcel.addEventListener('click', () => {
            const estadisticaSel = document.getElementById('estadisticaSelect').value;
            enviarAdm = document.getElementById('enviarAAdministradores').checked;
            excel = true;


            switch (estadisticaSel) {
                case 'ingresosServicios':
                    getDatosServicios(fechaIni, fechaFin, servicioSel, excel);
                    break;
                case 'ingresosMedicamentos':
                    getDatosMedicamentos(fechaIni, fechaFin, medicamentoSel, excel);

                    break;
                case 'serviciosRequeridos':
                    getDatosServiciosRequeridos(fechaIni, fechaFin, excel);
                    break;
                default:

            }

        });

        function getDatosServicios($fechaIni, $fechaFin, $servicio, $excel) {
            fetch(`/obtener-ingresos-servicios?fechaIni=${fechaIni}&fechaFin=${fechaFin}&servicio=${servicioSel}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    const nombresMeses = [];
                    const sumas = [];
                    data.forEach(item => {
                        nombresMeses.push(getMonthName(item.mes));
                        sumas.push(item.suma);
                    });
                    graficoBarra1.data.labels = nombresMeses;
                    graficoBarra1.data.datasets[0].data = sumas;
                    graficoBarra1.update();
                    if (excel == true) {
                        const dataToSend = [{
                            meses: nombresMeses,
                            montos: sumas,
                        }];
                        const fechaActual = new Date();
                        const fechaFormateada = `${fechaActual.getFullYear()}-${(fechaActual.getMonth() + 1).toString().padStart(2, '0')}-${fechaActual.getDate().toString().padStart(2, '0')}`;
                        const nombreArchivo = `reporte-ingresos-servicios-${fechaFormateada}.xlsx`;
                        generarExcel(dataToSend, nombreArchivo);
                        excel = false;
                    }
                })
                .catch(error => {
                    console.error('Error al cargar los resultados:', error);
                });
        }

        function getDatosMedicamentos($fechaIni, $fechaFin, $medicamento, $excel) {
            fetch(`/obtener-ingresos-medicamentos?fechaIni=${fechaIni}&fechaFin=${fechaFin}&medicamento=${medicamentoSel}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    const nombresMeses = [];
                    const sumas = [];
                    data.forEach(item => {
                        nombresMeses.push(getMonthName(item.mes));
                        sumas.push(item.suma);
                    });
                    if ($excel == true) {
                        const dataToSend = [{
                            meses: nombresMeses,
                            montos: sumas,
                        }];
                        const fechaActual = new Date();
                        const fechaFormateada = `${fechaActual.getFullYear()}-${(fechaActual.getMonth() + 1).toString().padStart(2, '0')}-${fechaActual.getDate().toString().padStart(2, '0')}`;
                        const nombreArchivo = `reporte-ingresos-medicamentos-${fechaFormateada}.xlsx`;
                        generarExcel(dataToSend, nombreArchivo);
                        excel = false;
                    }
                    graficoBarra2.data.labels = nombresMeses;
                    graficoBarra2.data.datasets[0].data = sumas;
                    graficoBarra2.update();
                })
                .catch(error => {
                    console.error('Error al cargar los resultados:', error);
                });
        }

        function getDatosServiciosRequeridos($fechaIni, $fechaFin, $excel) {
            fetch(`/obtener-servicios-requeridos?fechaIni=${fechaIni}&fechaFin=${fechaFin}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    const nombresServicios = [];
                    const porcentajes = [];
                    data.forEach(item => {
                        nombresServicios.push(item.nameservicio);
                        porcentajes.push(item.porcentaje);
                    });
                    if (excel == true) {
                        const dataToSend = [{
                            servicios: nombresServicios,
                            porcentajes: porcentajes,
                        }];
                        const fechaActual = new Date();
                        const fechaFormateada = `${fechaActual.getFullYear()}-${(fechaActual.getMonth() + 1).toString().padStart(2, '0')}-${fechaActual.getDate().toString().padStart(2, '0')}`;
                        const nombreArchivo = `reporte-servicios-requeridos-${fechaFormateada}.xlsx`;
                        generarExcel(dataToSend, nombreArchivo);
                        excel = false;
                    }
                    graficoPie1.data.labels = nombresServicios;
                    graficoPie1.data.datasets[0].data = porcentajes;
                    graficoPie1.update();
                })
                .catch(error => {
                    console.error('Error al cargar los resultados:', error);
                });
        }

        function generarExcel(dataToSend, nombreArchivo) {
            fetch('/generar-excel', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                    },
                    body: JSON.stringify(dataToSend),
                })
                .then(response => response.blob())
                .then(blob => {
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = nombreArchivo;
                    a.click();
                    window.URL.revokeObjectURL(url);
                    if (enviarAdm) {
                        enviarAdministradores(blob, nombreArchivo);
                    }
                    enviarAdm = false;
                })
                .catch(error => {
                    console.error('Error al generar el archivo Excel:', error);
                });
        }

        function enviarAdministradores(archivo, nombreArchivo) {
            //console.log("ARCHIVO: ", archivo);
            //console.log("NOMBRE ARCHIVO: ", nombreArchivo);
            const formData = new FormData();
            const archivoAdjunto = new File([archivo], nombreArchivo, { type: archivo.type });
            formData.append('archivo', archivoAdjunto);
            //console.log(archivoAdjunto);
            fetch('/enviar-administradores', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                    },
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Archivo enviado al controlador:', data);
                })
                .catch(error => {
                    console.error('Error al enviar el archivo al controlador:', error);
                });
        }
    });
</script>

@endsection