<?php

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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/monedas', [App\Http\Controllers\MonedaController::class, 'index'])->name('moneda');
Route::get('/cuentas', [App\Http\Controllers\CuentaController::class, 'index'])->name('cuenta');
Route::get('/categorias', [App\Http\Controllers\ControllerCategoria::class, 'index'])->name('categoria');
Route::get('/transacciones', [App\Http\Controllers\TransaccionController::class, 'index'])->name('transaccion');

Route::get('/deleteCoins', [App\Http\Controllers\MonedaController::class, 'destroy'])->name('deleteCoin');




