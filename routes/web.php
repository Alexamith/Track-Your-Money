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
    // Route::get('/home', function () {
    //     $un_dolar_es_igual_a = 610.74;
    //     $un_colon_es_igual_a = 0.0016;

    //     $cantidad_de_colones = 10564;
    //     $cantidad_de_dolares = 33;

    //     $conversion_euro_a_colones = $un_dolar_es_igual_a * $cantidad_de_dolares;
    //     $conversion_colones_a_dolares = $un_colon_es_igual_a * $cantidad_de_colones;

    //     echo $cantidad_de_dolares." dólares equivalen a ".number_format($conversion_euro_a_colones, 2)." <hr>";
    //     echo number_format($cantidad_de_colones, 2)." colones equivalen a ".number_format($conversion_colones_a_dolares, 2)." dólares";
    // });
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/monedas', [App\Http\Controllers\MonedaController::class, 'index'])->name('moneda');
Route::post('/monedas', [App\Http\Controllers\MonedaController::class, 'store'])->name('registra_moneda');
Route::get('/editMoneda/{id}', [App\Http\Controllers\MonedaController::class, 'edit'])->name('editMoneda');
Route::post('/update', [App\Http\Controllers\MonedaController::class, 'update'])->name('update');
Route::get('/deleteCoins/{id}', [App\Http\Controllers\MonedaController::class, 'destroy'])->name('deleteCoins');


Route::get('/transacciones', [App\Http\Controllers\TransaccionController::class, 'index'])->name('transaccion');



// Rutas cuentas
Route::get('/cuentas', [App\Http\Controllers\CuentaController::class, 'index'])->name('cuenta');
Route::post('/cuentas', [App\Http\Controllers\CuentaController::class, 'store'])->name('registra_cuenta');
Route::get('/borrarCuenta/{id}', [App\Http\Controllers\CuentaController::class, 'destroy'])->name('borrarCuenta');
Route::get('/editarCuenta/{id}', [App\Http\Controllers\CuentaController::class, 'edit'])->name('editarCuenta');
Route::post('/actualizarCuenta', [App\Http\Controllers\CuentaController::class, 'update'])->name('actualizarCuenta');


// Rutas categorias
Route::get('/categorias', [App\Http\Controllers\ControllerCategoria::class, 'index'])->name('categoria');
Route::post('/categorias', [App\Http\Controllers\ControllerCategoria::class, 'store'])->name('crear_categoria');
Route::get('/borrarCategoria/{id}', [App\Http\Controllers\ControllerCategoria::class, 'destroy'])->name('borrarCategoria');
