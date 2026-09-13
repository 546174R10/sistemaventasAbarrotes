<?php

use App\Http\Controllers\categoriaController;
use App\Http\Controllers\marcaController;
use App\Http\Controllers\presentacionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('template');
});

Route::view('/panel','panel.index')->name('panel');
// ruta de presentaciones

Route::resource('presentaciones',presentacionController::class);

//creacion de rutas desde web.php y mandar al controlador
// Route::view('/presentaciones','presentacion.index');

// vista de marcas
Route::view('/marcas', 'marca.index')->name('marca');

//creacion de rutas desde web.php y mandar al controlador
// Route::view('/categorias','categoria.index');

Route::view('/categoria','categoria.index')->name('categoria');
// redireccion para controla
Route::resource('marcas',marcaController::class);

Route::resource('categorias',categoriaController::class);

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/401', function () {
    return view('page.401');
});

Route::get('/404', function () {
    return view('page.404');
});

Route::get('/500', function () {
    return view('page.500');
});
