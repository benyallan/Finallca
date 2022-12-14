<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ContaCorrenteController,
    CarteiraController,
    HomeController,
    CartaoCreditoController,
    LancamentoController
};

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/auth', [HomeController::class, 'auth'])
->name('auth');

Route::middleware(['auth'])->group(function() {
    Route::prefix('/home')->group(function () {
        Route::get('', [HomeController::class, 'index'])
            ->name('home');

        // Carteiras
        Route::resource('carteiras', CarteiraController::class)
            ->only(['index','store','update','destroy']);
        Route::get('/carteiras/get', [CarteiraController::class, 'get'])
            ->name('carteiras.get');
        Route::get('/carteiras/get/list', [CarteiraController::class, 'getList'])
            ->name('carteiras.getlist');

        // Contas Corrente
        Route::resource('contascorrente', ContaCorrenteController::class)
            ->only(['index','store','update','destroy']);
        Route::get(
            '/contascorrente/get', [ContaCorrenteController::class, 'get']
        )->name('contascorrente.get');
        Route::get(
            '/contascorrente/get/list', 
            [ContaCorrenteController::class, 'getList']
        )->name('contascorrente.get.list');

        // Cartões de Crédito
        Route::resource('cartoescredito', CartaoCreditoController::class)
            ->only(['index','store','update','destroy']);
        Route::get(
            '/cartoescredito/get', [CartaoCreditoController::class, 'get']
        )->name('cartoescredito.get');
        Route::get(
            '/cartoescredito/get/list', [CartaoCreditoController::class, 'getList']
        )->name('cartoescredito.getlist');

        // Lançamentos
        Route::resource('lancamentos', LancamentoController::class)
            ->only(['index','store','update','destroy']);
        Route::get(
            '/lancamentos/get', [LancamentoController::class, 'get']
        )->name('lancamentos.get');
    });
});
