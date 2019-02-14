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
//Ajax para o dropdown de busca de disciplinas por período
Route::post('/disciplinas', 'AdjustmentsController@getFromPeriod');

Route::get('/admin/disciplinas', 'SubjectsController@index');
Route::get('/admin/disciplinas/{subject}/{division}', 'SubjectsController@show');
Route::get('/admin/disciplinas/{subject}/{division}/editar', 'SubjectsController@edit');
Route::post('/admin/disciplinas/{subject}/{division}/salvar', 'SubjectsController@store');





//Rota de distribuição de intent
Route::get('/login', 'IntentsController@show');

//Rotas de ajuste
Route::post('/ajuste', 'IntentsController@loginAdjustments');
Route::get('/ajuste', 'AdjustmentsController@show');
Route::post('/ajuste/confirmar', 'AdjustmentsController@confirm');
Route::post('/ajuste/modificar', 'AdjustmentsController@modify');
Route::post('/ajuste/salvar', 'AdjustmentsController@store');
Route::get('/ajuste/sucesso', 'AdjustmentsController@success');


//Rotas de certificados
Route::post('/certificados', 'IntentsController@loginCertificates');
Route::get('/certificados', 'CertificatesController@index');
Route::post('/certificados/evento/{event}', 'EventsController@certificate')->name('certificate');




//Rotas de login no sistema de gerenciamento
Route::get('/admin', 'AdminController@index');
Route::get('/admin/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/admin/login', 'Auth\LoginController@login');
Route::get('/admin/logout', 'Auth\LoginController@logout')->name('logout');
//Rotas de criação de gestores/usuários
Route::get('/admin/usuarios', 'UsersController@show');
Route::get('/admin/usuarios/criar', 'UsersController@create');
Route::post('/admin/usuarios/criar', 'UsersController@store');
//Rotas de gerenciamento do ajuste
Route::get('/admin/ajuste', 'AdminAdjustmentsController@show');
Route::post('/admin/ajuste/deferir', 'AdminAdjustmentsController@defer');
Route::post('/admin/ajuste/indeferir', 'AdminAdjustmentsController@deny');
Route::post('/admin/ajuste/filtrar', 'AdminAdjustmentsController@filter');
//Rotas de configurações do ajuste
Route::get('/admin/ajuste/config', 'ConfigAdjustmentsController@show');
Route::get('/admin/ajuste/config/editar', 'ConfigAdjustmentsController@edit');
Route::post('/admin/ajuste/config/editar', 'ConfigAdjustmentsController@save');
//Rotas de configurações dos certificados
Route::get('/admin/eventos', 'EventsController@index');
Route::get('/admin/eventos/templates', 'TemplatesController@index');
Route::post('/admin/eventos/templates', 'TemplatesController@store');


Route::get('/admin/eventos/criar', 'EventsController@create');
Route::post('/admin/eventos/criar', 'EventsController@store');
Route::get('/admin/eventos/{event}', 'EventsController@show');
Route::get('/admin/eventos/{event}/editar', 'EventsController@edit');
Route::patch('/admin/eventos/{event}', 'EventsController@update');




Route::get('/admin/eventos/configurar', 'AdminCertificatesController@configure');


//Auth::routes();



























