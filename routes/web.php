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

Route::get('/auth/redirect/{provider}', [App\Http\Controllers\Auth\LoginController::class, 'redirectToProvider']);
Route::get('/callback/{provider}', [App\Http\Controllers\Auth\LoginController::class, 'handleProviderCallback']);










Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/monedas', [App\Http\Controllers\MonedaController::class, 'index'])->name('moneda');
Route::post('/monedas', [App\Http\Controllers\MonedaController::class, 'store'])->name('registra_moneda');
Route::get('/editMoneda/{id}', [App\Http\Controllers\MonedaController::class, 'edit'])->name('editMoneda');
Route::post('/update', [App\Http\Controllers\MonedaController::class, 'update'])->name('update');
Route::get('/deleteCoins/{id}', [App\Http\Controllers\MonedaController::class, 'destroy'])->name('deleteCoins');






// Rutas cuentas
Route::get('/cuentas', [App\Http\Controllers\CuentaController::class, 'index'])->name('cuenta');
Route::post('/cuentas', [App\Http\Controllers\CuentaController::class, 'store'])->name('registra_cuenta');
Route::get('/borrarCuenta/{id}', [App\Http\Controllers\CuentaController::class, 'destroy'])->name('borrarCuenta');
Route::get('/editarCuenta/{id}', [App\Http\Controllers\CuentaController::class, 'edit'])->name('editarCuenta');
Route::get('/compartir/{id}', [App\Http\Controllers\CuentaController::class, 'compartir'])->name('compartir');
Route::post('/compartir', [App\Http\Controllers\CuentaController::class, 'compartirCuenta'])->name('compartirCuenta');
Route::post('/actualizarCuenta', [App\Http\Controllers\CuentaController::class, 'update'])->name('actualizarCuenta');


// Rutas categorias
Route::get('/categorias', [App\Http\Controllers\ControllerCategoria::class, 'index'])->name('categoria');
Route::get('/subcategoria', [App\Http\Controllers\ControllerCategoria::class, 'subcategoria'])->name('subcategoria');
Route::post('/categorias', [App\Http\Controllers\ControllerCategoria::class, 'store'])->name('crear_categoria');
Route::post('/subcategoria', [App\Http\Controllers\ControllerCategoria::class, 'storeSub'])->name('subcategoria');
Route::get('/borrarCategoria/{id}', [App\Http\Controllers\ControllerCategoria::class, 'destroy'])->name('borrarCategoria');
Route::get('/borrarSubCategoria/{id}', [App\Http\Controllers\ControllerCategoria::class, 'destroySub'])->name('borrarSubCategoria');
Route::get('/editarCategoria/{id}', [App\Http\Controllers\ControllerCategoria::class, 'edit'])->name('editarCategoria');
Route::get('/editarSubCategoria/{id}', [App\Http\Controllers\ControllerCategoria::class, 'editSub'])->name('editarSubCategoria');
Route::post('/actualizarCategoria', [App\Http\Controllers\ControllerCategoria::class, 'update'])->name('actualizarCategoria');
Route::post('/actualizarSubCategoria', [App\Http\Controllers\ControllerCategoria::class, 'updateSub'])->name('actualizarSubCategoria');


// rutas transaccion
Route::get('/transacciones', [App\Http\Controllers\TransaccionController::class, 'index'])->name('transaccion');
Route::post('/transacciones', [App\Http\Controllers\TransaccionController::class, 'store'])->name('crear_transacciones');
Route::get('/borrarTransaccion/{id}', [App\Http\Controllers\TransaccionController::class, 'destroy'])->name('borrarTransaccion');
Route::get('/editarTransacciones/{id}', [App\Http\Controllers\TransaccionController::class, 'edit'])->name('editarTransacciones');
Route::post('/actualizarTransacciones', [App\Http\Controllers\TransaccionController::class, 'update'])->name('actualizarTransacciones');

//rutas tasa
Route::get('/tasas', [App\Http\Controllers\tasaController::class, 'index'])->name('tasa');
Route::post('/registrar_tasa', [App\Http\Controllers\tasaController::class, 'store'])->name('registrar_tasa');
Route::get('/borrarTasa/{id}', [App\Http\Controllers\tasaController::class, 'destroy'])->name('borrarTasa');
Route::get('/editarTasa/{id}', [App\Http\Controllers\tasaController::class, 'edit'])->name('editarTasa');
Route::post('/actualizarTasa', [App\Http\Controllers\tasaController::class, 'update'])->name('actualizarTasa');


Route::get('/usuario', function () {
    $correo = $_REQUEST['correo'];
    $users = \DB::select("select * from users where email= "."'".$correo."'");
    
    return \Response::json($users);
});

Route::get('/graficos', [App\Http\Controllers\GraficosController::class, 'Cuentas_actuales_con_sus_respectivos_saldos']);

// Route::get('/graficos', [App\Http\Controllers\GraficosController::class, 'principales_ingresos']);