<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;

Route::get('/items', [ItemController::class, 'index']); // Endpoint GET
Route::post('/items', [ItemController::class, 'store']); // Endpoint POST
Route::get('/items/{id}', [ItemController::class, 'show']); // Exibir um item específico
Route::put('/items/{id}', [ItemController::class, 'update']); // Atualizar um item
Route::delete('/items/{id}', [ItemController::class, 'destroy']); // Excluir um item


Route::get('/', function () {
    return view('index');
});

