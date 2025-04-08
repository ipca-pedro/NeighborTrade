<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\AnuncioController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\NotificacaoController;
use Illuminate\Support\Facades\Route;

// Rotas públicas
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::get('/moradas/test', [\App\Http\Controllers\MoradaController::class, 'test']);
Route::get('/moradas', [\App\Http\Controllers\MoradaController::class, 'index']);
Route::post('/moradas', [\App\Http\Controllers\MoradaController::class, 'store']);
Route::post('/auth/reset-password', [PasswordResetController::class, 'resetPassword']);
Route::get('/auth/verify-email/{token}', [AuthController::class, 'verifyEmail']);
Route::post('/auth/resend-verification', [AuthController::class, 'resendVerification']);

// Rotas públicas de produtos
Route::get('/produtos', [ProdutoController::class, 'index']);
Route::get('/produtos/{id}', [ProdutoController::class, 'show']);

// Rotas públicas de anúncios
Route::get('/anuncios', [AnuncioController::class, 'index']);
Route::get('/anuncios/procurar', [AnuncioController::class, 'procurar']);
Route::get('/anuncios/tipo/{tipoId}', [AnuncioController::class, 'porTipo']);
Route::get('/anuncios/categoria/{categoriaId}', [AnuncioController::class, 'porCategoria']);
Route::get('/anuncios/{id}', [AnuncioController::class, 'show']);

// Rotas protegidas
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::put('/auth/change-password', [AuthController::class, 'changePassword']);
    Route::delete('/auth/delete-account', [AuthController::class, 'deleteAccount']);
    
    // Perfil routes
    Route::get('/perfil', [PerfilController::class, 'show']);
    Route::put('/perfil', [PerfilController::class, 'update']);
    Route::put('/perfil/morada', [PerfilController::class, 'updateMorada']);
    Route::post('/perfil/foto', [PerfilController::class, 'updateFotoPerfil']);
    Route::get('/perfil/anuncios/historico', [PerfilController::class, 'historicoAnuncios']);
    
    // Anúncios do usuário autenticado
    Route::get('/meus-anuncios', [AnuncioController::class, 'meusAnuncios']);
    
    // Notificações
    Route::prefix('notificacoes')->group(function () {
        Route::get('/', [NotificacaoController::class, 'index']);
        Route::get('/recentes/count', [NotificacaoController::class, 'contarRecentes']);
        Route::get('/{id}', [NotificacaoController::class, 'show']);
        Route::put('/{id}/visualizar', [NotificacaoController::class, 'registrarVisualizacao']);
        Route::put('/todas/visualizar', [NotificacaoController::class, 'marcarTodasVistas']);
        Route::delete('/{id}', [NotificacaoController::class, 'destroy']);
        Route::delete('/antigas/limpar', [NotificacaoController::class, 'limparNotificacoesAntigas']);
    });

    // Rotas de administração
    Route::prefix('admin')->group(function () {
        Route::get('/pending-users', [AdminController::class, 'listPendingUsers']);
        Route::post('/approve-user/{id}', [AdminController::class, 'approveUser']);
        Route::post('/reject-user/{id}', [AdminController::class, 'rejectUser']);
        Route::get('/produtos/pendentes', [ProdutoController::class, 'listPendentes']);
        Route::post('/produtos/{id}/aprovar', [ProdutoController::class, 'aprovar']);
        Route::post('/produtos/{id}/rejeitar', [ProdutoController::class, 'rejeitar']);
    });

    // Rotas de anúncios
    Route::post('/anuncios', [AnuncioController::class, 'store']);
    Route::put('/anuncios/{id}', [AnuncioController::class, 'update']);
    Route::delete('/anuncios/{id}', [AnuncioController::class, 'destroy']);
});
