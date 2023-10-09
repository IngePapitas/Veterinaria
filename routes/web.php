<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EspecialidadController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\RazaController;
use App\Http\Controllers\EspecieController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('Dashboard');

    Route::get('/personal', [PersonalController::class, 'index'])->name('Personal.index');
    Route::get('/personal/create', [PersonalController::class, 'create'])->name('Personal.create');
    Route::post('/personal', [PersonalController::class, 'store'])->name('Personal.store');
    Route::get('/personal/{personal}/edit', [PersonalController::class, 'edit'])->name('Personal.edit');
    Route::put('/personal/{personal}', [PersonalController::class, 'update'])->name('Personal.update');
    Route::get('/buscar-personal', [PersonalController::class, 'buscarPersonal'])->name('Personal.buscarPersonal');
    Route::put('/personal/{personal}/baja', [PersonalController::class, 'baja'])->name('Personal.baja');
    Route::get('/buscar-especialidades-create', [EspecialidadController::class, 'buscarEspecilalidad'])->name('Especialidad.buscarEspecilalidad');
    Route::delete('/personal/{personal}', [PersonalController::class, 'destroy'])->name('Personal.destroy');

    Route::get('/paciente', [PacienteController::class, 'index'])->name('Paciente.index');
    Route::get('/paciente/create', [PacienteController::class, 'create'])->name('Paciente.create');
    Route::post('/paciente', [PacienteController::class, 'store'])->name('Paciente.store');
    Route::get('/paciente/{paciente}/edit', [PacienteController::class, 'edit'])->name('Paciente.edit');
    Route::put('/paciente/{paciente}', [PacienteController::class, 'update'])->name('Paciente.update');
    Route::get('/buscar-paciente', [PacienteController::class, 'buscarPaciente'])->name('Paciente.buscarPaciente');

    Route::get('/buscar-especie-imagen', [EspecieController::class, 'buscarEspecieImagen'])->name('Especie.buscarImagen');
    Route::get('/buscar-especies-create', [EspecieController::class, 'buscarEspecie'])->name('Especie.buscarEspecie');

    Route::get('/buscar-razas-create', [RazaController::class, 'buscarRaza'])->name('Raza.buscarRaza');

    Route::get('/especie', [EspecieController::class, 'index'])->name('Especie.index');
    Route::get('/especie/create', [EspecieController::class, 'create'])->name('Especie.create');
    Route::post('/especie', [EspecieController::class, 'store'])->name('Especie.store');
    Route::get('/especie/{especie}/edit', [EspecieController::class, 'edit'])->name('Especie.edit');
    Route::put('/especie/{especie}', [EspecieController::class, 'update'])->name('Especie.update');
    Route::get('/buscar-especie', [EspecieController::class, 'buscarEspecieIndex'])->name('Especie.buscarEspecie');
    Route::delete('/especie/{especie}', [EspecieController::class, 'destroy'])->name('Especie.destroy');
});
