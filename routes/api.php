<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/mascotas', [AuthController::class, 'mascotas']);
    Route::get('/citas', [AuthController::class, 'citas']);
    Route::get('/carrito', [AuthController::class, 'carrito']);
    Route::post('/addcart', [AuthController::class, 'addToCart']);
    Route::get('/misnotas', [AuthController::class, 'notasDeServicio']);
    Route::post('/valoracion', [AuthController::class, 'valoracion']);
});

Route::get('/productos',[AuthController::class, 'productos']);