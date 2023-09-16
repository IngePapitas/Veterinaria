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
    Route::get('/personal/{personal}', [PersonalController::class, 'edit'])->name('Personal.edit');
    Route::put('/personal', [PersonalController::class, 'update'])->name('Personal.update');
    Route::post('/buscar-personal', [PersonalController::class, 'buscarPersonal'])->name('Personal.buscarPersonal');
    Route::get('/buscar-especialidades-create', [EspecialidadController::class, 'buscarEspecilalidad'])->name('Especialidad.buscarEspecilalidad');
    Route::delete('/personal', [PersonalController::class, 'destroy'])->name('Personal.destroy');
});
