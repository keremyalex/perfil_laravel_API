<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');

Route::post('/register', [RegisterController::class, 'register']);

Route::get('file/imagen_perfil', [RegisterController::class, 'imagen']);
Route::post('file/imagen_save', [RegisterController::class, 'imagenSave']);

Route::get('/users', [UserController::class, 'allUsers']);
