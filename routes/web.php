<?php

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

Route::get('/categoria', function () { return view('admin.categoria'); })->name('categoria');
Route::get('/categoria/listar', 'CategoriaController@listar');
Route::post('/categoria/registrar', 'CategoriaController@store');
Route::put('/categoria/actualizar', 'CategoriaController@update');
Route::put('/categoria/desactivar', 'CategoriaController@desactivar');
Route::put('/categoria/activar', 'CategoriaController@activar');
Route::get('/categoria/selectCategoria', 'CategoriaController@selectCategoria');

Route::get('/sabor', function () { return view('admin.sabor'); })->name('sabor');
Route::get('/sabor/listar', 'SaborController@listar');
Route::post('/sabor/registrar', 'SaborController@store');
Route::put('/sabor/actualizar', 'SaborController@update');
Route::put('/sabor/desactivar', 'SaborController@desactivar');
Route::put('/sabor/activar', 'SaborController@activar');
Route::get('/sabor/selectSabor', 'SaborController@selectSabor');

Route::get('/tamano', function () { return view('admin.tamano'); })->name('tamano');
Route::get('/tamano/listar', 'TamanoController@listar');
Route::post('/tamano/registrar', 'TamanoController@store');
Route::put('/tamano/actualizar', 'TamanoController@update');
Route::put('/tamano/desactivar', 'TamanoController@desactivar');
Route::put('/tamano/activar', 'TamanoController@activar');
Route::get('/tamano/selectTamano', 'TamanoController@selectTamano');

Route::get('/producto', function () { return view('admin.producto'); })->name('producto');
Route::get('/producto/listar', 'ProductoController@listar');
Route::post('/producto/registrar', 'ProductoController@store');
Route::put('/producto/actualizar', 'ProductoController@update');
Route::put('/producto/desactivar', 'ProductoController@desactivar');
Route::put('/producto/activar', 'ProductoController@activar');

Auth::routes();



Route::get('/home', 'HomeController@index')->name('home');
