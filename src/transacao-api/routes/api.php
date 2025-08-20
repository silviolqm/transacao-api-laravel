<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransacaoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/transacoes', [TransacaoController::class, 'store']);
    Route::get('/transacoes', [TransacaoController::class, 'index']);
    Route::get('/transacoes/{id}', [TransacaoController::class, 'show']);
    Route::match(['put', 'patch'], '/transacoes/{id}', [TransacaoController::class, 'update']);
    Route::delete('/transacoes/{id}', [TransacaoController::class, 'destroy']);
});
