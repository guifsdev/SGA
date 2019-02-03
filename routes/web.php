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
Route::get('/home', 'HomeController@index')->name('home');

Route::any('/subjects', 'SubjectsController@show');


//Login aluno
Route::get('/login', 'IntentsController@show');

//Rotas de ajuste
Route::post('/ajuste/login', 'IntentsController@loginAdjustments');
Route::get('/ajuste', 'AdjustmentsController@show');
Route::post('/ajuste/confirmar', 'AdjustmentsController@confirm');
Route::post('/ajuste/modificar', 'AdjustmentsController@modify');
Route::post('/ajuste', 'AdjustmentsController@store');
Route::get('/ajuste/sucesso', 'AdjustmentsController@success');

//Rotas de certificados
Route::post('/certificados/login', 'IntentsController@loginCertificates');
Route::get('/certificados', 'CertificatesController@show');

//Rotas de gerenciamento
Route::get('/admin', 'AdminController@index');
Route::get('/admin/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/admin/login', 'Auth\LoginController@login');
Route::get('/admin/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/admin/ajuste', 'AdminAdjustmentsController@show');

//Rotas de acoes
Route::post('/admin/ajuste/deferir', 'AdminAdjustmentsController@defer');
Route::post('/admin/ajuste/indeferir', 'AdminAdjustmentsController@deny');


//Filtragem 
Route::post('/admin/ajuste/filtrar', 'AdminAdjustmentsController@filter');


Route::get('/admin/ajuste/configurar', 'AdminAdjustmentsController@configure');


Route::get('/admin/certificados', 'AdminCertificatesController@show');
Route::get('/admin/certificados/configurar', 'AdminCertificatesController@configure');




//Auth::routes();





