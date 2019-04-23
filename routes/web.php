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
    return view('content.content');
});


Route::get('/categoria', 'CategorieController@index');  
Route::post('/categoria/registrar', 'CategorieController@store'); 
Route::put('/categoria/actualizar', 'CategorieController@update');  
Route::put('/categoria/desactivar', 'CategorieController@desactivate');  
Route::put('/categoria/activar', 'CategorieController@activate');  
Route::get('/categoria/selectCategoria', 'CategorieController@selectCategoria');  


Route::get('/articulo', 'ArticleController@index');  
Route::post('/articulo/registrar', 'ArticleController@store'); 
Route::put('/articulo/actualizar', 'ArticleController@update');  
Route::put('/articulo/desactivar', 'ArticleController@desactivate');  
Route::put('/articulo/activar', 'ArticleController@activate');  


Route::get('/cliente', 'ClienteController@index');  
Route::post('/cliente/registrar', 'ClienteController@store'); 
Route::put('/cliente/actualizar', 'ClienteController@update');  


Route::get('/proveedor', 'ProveedorController@index');  
Route::post('/proveedor/registrar', 'ProveedorController@store'); 
Route::put('/proveedor/actualizar', 'ProveedorController@update');  