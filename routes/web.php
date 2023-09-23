<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EspecialidadController;
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
    
});
