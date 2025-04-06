<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\AnuncioController;
use Illuminate\Support\Facades\Route;

// Rotas públicas
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/reset-password', [PasswordResetController::class, 'resetPassword']);
Route::get('/auth/verify-email/{token}', [AuthController::class, 'verifyEmail']);
Route::post('/auth/resend-verification', [AuthController::class, 'resendVerification']);

// Rotas públicas de produtos
Route::get('/produtos', [ProdutoController::class, 'index']);
Route::get('/produtos/{id}', [ProdutoController::class, 'show']);

// Rotas públicas de anúncios
Route::get('/anuncios', [AnuncioController::class, 'index']);
Route::get('/anuncios/buscar', [AnuncioController::class, 'buscar']);
Route::get('/anuncios/tipo/{tipoId}', [AnuncioController::class, 'porTipo']);
Route::get('/anuncios/categoria/{categoriaId}', [AnuncioController::class, 'porCategoria']);
Route::get('/anuncios/{id}', [AnuncioController::class, 'show']);

// Rotas protegidas
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);

    // Rotas de administração
    Route::prefix('admin')->group(function () {
        Route::get('/pending-users', [AdminController::class, 'getPendingUsers']);
        Route::post('/approve-user/{id}', [AdminController::class, 'approveUser']);
        Route::post('/reject-user/{id}', [AdminController::class, 'rejectUser']);
        Route::get('/produtos/pendentes', [ProdutoController::class, 'listPendentes']);
        Route::post('/produtos/{id}/aprovar', [ProdutoController::class, 'aprovar']);
        Route::post('/produtos/{id}/rejeitar', [ProdutoController::class, 'rejeitar']);
    });

    // Rotas de produtos
    Route::post('/produtos', [ProdutoController::class, 'store']);
    Route::put('/produtos/{id}', [ProdutoController::class, 'update']);
    Route::delete('/produtos/{id}', [ProdutoController::class, 'destroy']);
});
