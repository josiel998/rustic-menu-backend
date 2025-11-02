<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\PratoController;
use App\Models\User;





// --- Rotas Públicas ---
// Rota de Login (do Login.tsx)
Route::post('/login', [AuthController::class, 'login']);
Route::get('/pratos', [PratoController::class, 'index']);

// Rota para criar pedido (do OrderForm.tsx)
Route::post('/pedidos', [OrderController::class, 'store']);

Route::get('/pedidos/status/{uuid}', [OrderController::class, 'showPublic']);


// --- Rotas Protegidas (Exigem Login) ---
// O frontend envia 'requiresAuth: true'
Route::middleware('auth:sanctum')->group(function () {

    // Rota de Logout (do Header.tsx)
    Route::post('/logout', [AuthController::class, 'logout']);

    // Rota padrão do Sanctum para verificar o usuário
    Route::get('/user', function (Request $request) {
        return $request->user();
    });


// Route::apiResource('pratos', PratoController::class);

Route::post('/pratos', [PratoController::class, 'store']);
    Route::put('/pratos/{prato}', [PratoController::class, 'update']);    // Para editar
    Route::patch('/pratos/{prato}', [PratoController::class, 'update']); // Para editar
    Route::delete('/pratos/{prato}', [PratoController::class, 'destroy']);

    // Rota para listar pedidos (do Orders.tsx)
    Route::get('/pedidos', [OrderController::class, 'index']);
    Route::post('/pedidos/reset', [OrderController::class, 'resetOrders']);

    // Rota para atualizar status do pedido (do Orders.tsx)
    Route::patch('/pedidos/{order}', [OrderController::class, 'update']);
});