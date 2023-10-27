<?php

use App\Http\Controllers\CategoriaMedicamentoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EspecialidadController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\RazaController;
use App\Http\Controllers\EspecieController;
use App\Http\Controllers\LaboratorioController;
use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\NotaServicioController;
use App\Http\Controllers\ServicioController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Vistas del encabezado de la pagina
Route::get('/', function () {
    return view('welcome');
})->name('welcome');
Route::get('/servicios-ofrecidos', function () {
    return view('VistaWelcome.servicios');
})->name('servicios-ofrecidos');
Route::get('/productos', function () {
    return view('VistaWelcome.productos');
})->name('productos');
Route::get('/contacto', function () {
    return view('VistaWelcome.contacto');
})->name('contacto');
Route::get('/nuestro-equipo', function () {
    return view('VistaWelcome.equipo');
})->name('equipo');


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('Dashboard');

    //PERSONAL HECHO POR ELIO 
    Route::get('/personal', [PersonalController::class, 'index'])->name('Personal.index');
    Route::get('/personal/create', [PersonalController::class, 'create'])->name('Personal.create');
    Route::post('/personal', [PersonalController::class, 'store'])->name('Personal.store');
    Route::get('/personal/{personal}/edit', [PersonalController::class, 'edit'])->name('Personal.edit');
    Route::put('/personal/{personal}', [PersonalController::class, 'update'])->name('Personal.update');
    Route::get('/buscar-personal', [PersonalController::class, 'buscarPersonal'])->name('Personal.buscarPersonal');
    Route::put('/personal/{personal}/baja', [PersonalController::class, 'baja'])->name('Personal.baja');
    Route::get('/buscar-especialidades-create', [EspecialidadController::class, 'buscarEspecilalidad'])->name('Especialidad.buscarEspecilalidad');
    Route::delete('/personal/{personal}', [PersonalController::class, 'destroy'])->name('Personal.destroy');

    //PACIENTES BY TUMO RENI TORIKO
    Route::get('/paciente', [PacienteController::class, 'index'])->name('Paciente.index');
    Route::get('/paciente/create', [PacienteController::class, 'create'])->name('Paciente.create');
    Route::post('/paciente', [PacienteController::class, 'store'])->name('Paciente.store');
    Route::get('/paciente/{paciente}/edit', [PacienteController::class, 'edit'])->name('Paciente.edit');
    Route::put('/paciente/{paciente}', [PacienteController::class, 'update'])->name('Paciente.update');
    Route::get('/buscar-paciente', [PacienteController::class, 'buscarPaciente'])->name('Paciente.buscarPaciente');

    //BUSCADORES DE ESPECIES, CREADOR DE PACIENTES
    Route::get('/buscar-especie-imagen', [EspecieController::class, 'buscarEspecieImagen'])->name('Especie.buscarImagen');
    Route::get('/buscar-especies-create', [EspecieController::class, 'buscarEspecie'])->name('Especie.buscarEspecie');

    //BUSCADOR DE RAZAS EN LA CREACION DE PACIENTES
    Route::get('/buscar-razas-create', [RazaController::class, 'buscarRaza'])->name('Raza.buscarRaza');

    //ESPECIES BY ELITO TU MORINITO
    Route::get('/especie', [EspecieController::class, 'index'])->name('Especie.index');
    Route::get('/especie/create', [EspecieController::class, 'create'])->name('Especie.create');
    Route::post('/especie', [EspecieController::class, 'store'])->name('Especie.store');
    Route::get('/especie/{especie}/edit', [EspecieController::class, 'edit'])->name('Especie.edit');
    Route::put('/especie/{especie}', [EspecieController::class, 'update'])->name('Especie.update');
    Route::get('/buscar-especie', [EspecieController::class, 'buscarEspecieIndex'])->name('Especie.buscarEspecie');
    Route::delete('/especie/{especie}', [EspecieController::class, 'destroy'])->name('Especie.destroy');

    Route::get('/medicamento', [MedicamentoController::class, 'index'])->name('Medicamento.index');
    Route::get('/medicamento/create', [MedicamentoController::class, 'create'])->name('Medicamento.create');
    Route::post('/medicamento', [MedicamentoController::class, 'store'])->name('Medicamento.store');
    Route::get('/medicamento/{medicamento}/edit', [MedicamentoController::class, 'edit'])->name('Medicamento.edit');
    Route::put('/medicamento/{medicamento}', [MedicamentoController::class, 'update'])->name('Medicamento.update');
    Route::delete('/medicamento/{medicamento}', [MedicamentoController::class, 'destroy'])->name('Medicamento.destroy');
    Route::get('/buscar-laboratorio-create', [LaboratorioController::class, 'buscarLaboratorio'])->name('Laboratorio.buscarLaboratorio');
    Route::get('/buscar-categoriamedicamento-create', [CategoriaMedicamentoController::class, 'buscarCategoriaMedicamento'])->name('Categoriamedicamento.buscarCategoriaMedicamento');

    //ROLES BY PAPITAS
    Route::get('/role/{role}/edit', [RoleController::class, 'edit'])->name('Role.edit');
    Route::delete('/role/{role}', [RoleController::class, 'destroy'])->name('Role.destroy');
    Route::get('/role/create', [RoleController::class, 'create'])->name('Role.create');
    Route::post('/role', [RoleController::class, 'store'])->name('Role.store');
    Route::put('/role/{role}', [RoleController::class, 'update'])->name('Role.update');

    //USUARIOS POR ELITO YA TU SABE
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('Usuario.index');
    Route::get('/usuarios/create', [UsuarioController::class, 'create'])->name('Usuario.create');
    Route::get('/usuarios/{usuario}', [UsuarioController::class, 'edit'])->name('Usuario.edit');
    Route::delete('/usuarios/{usuario}', [UsuarioController::class, 'destroy'])->name('Usuario.destroy');
    Route::put('/usuarios/{usuario}', [UsuarioController::class, 'update'])->name('Usuario.update');
    Route::post('/usuarios', [UsuarioController::class, 'store'])->name('Usuario.store');
    Route::get('/buscar-usuario', [UsuarioController::class, 'buscarUsuario'])->name('Usuario.buscar');

    //CLIENTES (ESTO LO HIZO UN TORCIDO)
    Route::get('/clientes', [ClienteController::class, 'index'])->name('Cliente.index');
    Route::get('/clientes/create', [ClienteController::class, 'create'])->name('Cliente.create');
    Route::post('/clientes', [ClienteController::class, 'store'])->name('Cliente.store');
    Route::get('/clientes/{cliente}/edit', [ClienteController::class, 'edit'])->name('Cliente.edit');
    Route::put('/clientes/{cliente}', [ClienteController::class, 'update'])->name('Cliente.update');
    Route::delete('/clientes/{cliente}', [ClienteController::class, 'destroy'])->name('Cliente.destroy');
    Route::get('/buscar-clientes', [ClienteController::class, 'buscarClientes'])->name('buscar.clientes');

    //NOTAS SERVICIO POR TUMO
    Route::get('/notasservicio', [NotaServicioController::class, 'index'])->name('NotaServicio.index');
    Route::get('/notasservicio/create', [NotaServicioController::class, 'create'])->name('NotaServicio.create');
    Route::post('/notasservicio', [NotaServicioController::class, 'store'])->name('NotaServicio.store');
    Route::get('/notasservicio/{notasservicio}/edit', [NotaServicioController::class, 'edit'])->name('NotaServicio.edit');
    Route::put('/notasservicio/{cliente}', [NotaServicioController::class, 'update'])->name('NotaServicio.update');
    Route::delete('/notasservicio/{cliente}', [NotaServicioController::class, 'destroy'])->name('NotaServicio.destroy');
    Route::get('/buscar-notasservicio', [NotaServicioController::class, 'buscarNotasServicio'])->name('NotaServicio.clientes');

    //NOTAS SERVICIO YA TU SABE POR QUIEN
    Route::get('/servicios', [ServicioController::class, 'index'])->name('Servicio.index');
    Route::get('/servicios/create', [ServicioController::class, 'create'])->name('Servicio.create');
    Route::post('/servicios', [ServicioController::class, 'store'])->name('Servicio.store');
    Route::get('/servicios/{servicios}/edit', [ServicioController::class, 'edit'])->name('Servicio.edit');
    Route::put('/servicios/{servicios}', [ServicioController::class, 'update'])->name('Servicio.update');
    Route::delete('/servicios/{servicios}', [ServicioController::class, 'destroy'])->name('Servicio.destroy');
    Route::get('/buscar-servicios', [ServicioController::class, 'buscarNotasServicio'])->name('Servicio.clientes');
    Route::get('/buscar-servicios-create', [ServicioController::class, 'buscarServiciosCreate'])->name('Servicio.buscarServicio');
}) ;
