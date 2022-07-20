<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ContaCorrenteController,
    CarteiraController,
    HomeController
};

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/auth', [HomeController::class, 'auth'])
->name('auth');

Route::prefix('/home')->group(function () {
    Route::get('', [HomeController::class, 'index'])
        ->name('home');

    // Carteiras
    Route::resource('carteiras', CarteiraController::class)
        ->only(['store','update','destroy']);
    Route::get('/carteiras/get', [CarteiraController::class, 'get'])
        ->name('carteiras.get');

    // Contas Corrente
    Route::resource('contascorrente', ContaCorrenteController::class)
        ->only(['store','update','destroy']);
    Route::get('/contascorrente/get', [ContaCorrenteController::class, 'get'])
        ->name('contascorrente.get');
        
    Route::get('/{any}', [HomeController::class, 'index'])
        ->where('any', '.*');
});

