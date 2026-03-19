<?php

use App\Http\Controllers\TrabajadorController;
use Illuminate\Support\Facades\Route;

Route::prefix('trabajadores')->group(function () {
    Route::get('/', [TrabajadorController::class, 'index']);
    Route::post('/', [TrabajadorController::class, 'store']);
    Route::get('/catalogos', [TrabajadorController::class, 'catalogos']);
    Route::get('/{id}', [TrabajadorController::class, 'show']);
    Route::put('/{id}', [TrabajadorController::class, 'update']);
    Route::delete('/{id}', [TrabajadorController::class, 'destroy']);
});
