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

Route::get('/', 'AjustesController@index')->name('home');

Route::get('/consulta', 'AjustesController@mostrar');

Route::post('/consulta', 'RequerimentosController@consultar');

Route::get('/ajuste', 'AjustesController@ajustar');

Route::any('/disciplinas', 'AjustesController@buscarDisciplinas');

Route::post('/ajuste', 'RequerimentosController@adicionar');

Auth::routes();

Route::get('/home', 'HomeController@index');
