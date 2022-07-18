<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
Route::get('/contascorrente', [App\Http\Controllers\ContaCorrenteController::class, 'index'])->name('contascorrente.index');
Route::post('/contascorrente', [App\Http\Controllers\ContaCorrenteController::class, 'store'])->name('contascorrente.store');
Route::put('/contascorrente/{contaCorrente}', [App\Http\Controllers\ContaCorrenteController::class, 'update'])->name('contascorrente.update');
Route::get('/contascorrente/get', [App\Http\Controllers\ContaCorrenteController::class, 'get'])->name('contascorrente.get');
Route::delete('/contascorrente/{contaCorrente}', [App\Http\Controllers\ContaCorrenteController::class, 'destroy'])->name('contascorrente.destroy');
