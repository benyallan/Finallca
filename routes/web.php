<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContaCorrenteController;

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Carteiras
Route::get('/carteiras', [App\Http\Controllers\CarteiraController::class, 'index'])->name('carteira.index');
Route::post('/carteiras', [App\Http\Controllers\CarteiraController::class, 'store'])->name('carteira.store');
Route::get('/carteiras/get', [App\Http\Controllers\CarteiraController::class, 'get'])->name('carteira.get');

// Contas Corrente
Route::resource('contascorrente', ContaCorrenteController::class)
    ->only(['index','store','update','destroy']);
Route::get('/contascorrente/get', [ContaCorrenteController::class, 'get'])
    ->name('contascorrente.get');
