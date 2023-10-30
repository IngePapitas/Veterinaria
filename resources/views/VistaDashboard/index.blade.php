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
            @foreach ($servicios as $servicio)
            <option value="{{ $servicio->id }}">{{ $servicio->descripcion }}</option>
            @endforeach
        </select>

        <select id="medicamentoSelect" class="p-2 border rounded">
            <option value="" disabled selected>Medicamento..</option>
            @foreach ($medicamentos as $medicamento)
            <option value="{{ $medicamento->id }}">{{ $medicamento->nombre }}</option>
            @endforeach
        </select>

        <button class="bg-blue-500 text-white p-2 rounded" id="btnFiltro">Generar</button>

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
</div>


<script>
    document.addEventListener('DOMContentLoaded', () => {

        const ctxServicios = document.getElementById('ventasPorMes').getContext('2d');
        const ctxMedicamentos = document.getElementById('ventasPorMesMedicamentos').getContext('2d');
        const ctxPieServicios = document.getElementById('serviciosRequeridos').getContext('2d');

        let graficoPie1;
        let fechaIni = '';
        let fechaFin = '';
        let servicioSel = '';
        let medicamentoSel = '';
        let graficoBarra2;
        let graficoBarra1;

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

        const btnFiltro = document.getElementById('btnFiltro');
        btnFiltro.addEventListener('click', () => {
            fechaIni = document.getElementById('mesAnioInicioSelect').value;
            fechaFin = document.getElementById('mesAnioFinalSelect').value;
            servicioSel = document.getElementById('servicioSelect').value;
            getDatosServicios(fechaIni, fechaFin, servicioSel);
            getDatosMedicamentos(fechaIni, fechaFin, medicamentoSel);
            getDatosServiciosRequeridos(fechaIni, fechaFin)
        });

        function getDatosServicios($fechaIni, $fechaFin, $servicio) {
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
                })
                .catch(error => {
                    console.error('Error al cargar los resultados:', error);
                });
        }

        function getDatosMedicamentos($fechaIni, $fechaFin, $medicamento) {
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
                    graficoBarra2.data.labels = nombresMeses;
                    graficoBarra2.data.datasets[0].data = sumas;
                    graficoBarra2.update();
                })
                .catch(error => {
                    console.error('Error al cargar los resultados:', error);
                });
        }

        function getDatosServiciosRequeridos($fechaIni, $fechaFin, $medicamento) {
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
                    graficoPie1.data.labels = nombresServicios;
                    graficoPie1.data.datasets[0].data = porcentajes;
                    graficoPie1.update();
                })
                .catch(error => {
                    console.error('Error al cargar los resultados:', error);
                });
        }
    });
</script>

@endsection