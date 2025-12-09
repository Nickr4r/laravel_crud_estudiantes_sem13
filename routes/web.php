<?php

use Illuminate\Support\Facades\Route;

/*
Route::get('/', function () {
    return view('welcome');
});
*/

use App\Http\Controllers\EstudianteController;

Route::get('/', [EstudianteController::class, 'index']);
Route::post('/guardar', [EstudianteController::class, 'store']);
Route::post('/actualizar/{id}', [EstudianteController::class, 'update']);
Route::post('/eliminar/{id}', [EstudianteController::class, 'destroy']);
