<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ContaCorrenteController,
    CarteiraController
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home');
Route::get('/auth', [App\Http\Controllers\HomeController::class, 'auth'])
    ->name('auth');

// Carteiras
Route::resource('carteiras', CarteiraController::class)
    ->only(['index','store','update','destroy']);
Route::get('/carteiras/get', [CarteiraController::class, 'get'])
    ->name('carteiras.get');

// Contas Corrente
Route::resource('contascorrente', ContaCorrenteController::class)
    ->only(['index','store','update','destroy']);
Route::get('/contascorrente/get', [ContaCorrenteController::class, 'get'])
    ->name('contascorrente.get');
