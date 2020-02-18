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

Route::prefix('estudante')->group(function() {
	Route::get('login', 'StudentLoginController@showLoginForm');
	Route::post('login', 'StudentLoginController@login');
	Route::get('logout', 'StudentLoginController@logout');
	Route::get('home', 'StudentHomeController@home');

	Route::get('adjustment/index', 'StudentAdjustmentController@index');
	Route::post('adjustment/store', 'StudentAdjustmentController@store');
});

//Route::prefix('adjustment')->group(function() {
	//Route::get('index', 'AdjustmentsController@index');
//});


//Route::get('/', 'SpaController@index');

//Route::post('/disciplinas', 'SubjectsController@subjects');

////Route::get('/certificado/validar', 'CertificatesController@hashValidator');
////Route::get('/certificado/validar/{hash}', 'CertificatesController@hashValidate');
//Route::get('/certificado/validar', 'CertificatesController@hashValidator');

//Route::middleware('student')->get('/subjects/{period}', function($period) {
	////$subjects = Subject::where('period', $period)->get();
	//$subjects = Subject::fromPeriod($period);
	//return response($subjects, 200);
//});

//Route::middleware('student')->get('/setting/max-ajustes', function() {
	//$maxAjustes = Setting::where('nome', 'max_ajustes')->first()['valor'];
	//return response($maxAjustes, 200);
//});


//Route::patch('/estudante/update', 'StudentsController@update');


//Route::post('/estudante/certificados', 'StudentsController@certificates');
//Route::get('/estudante/certificado/{certificate}', 'CertificatesController@print');


//Route::get('/estudante/', 'SpaController@index');
//Route::get('/estudante/{any}', 'SpaController@index')->where('any', '.*');

////Auth::routes();



//Route::get('/ajuste/status', 'AdjustmentsController@status');


//Route::get('/admin', 'AdminController@index');
//Route::get('/admin/login', 'Auth\LoginController@showLoginForm')->name('login');
//Route::post('/admin/login', 'Auth\LoginController@login');
//Route::get('/admin/logout', 'Auth\LoginController@logout')->name('logout');


//Route::get('/admin/ajuste/config', 'AdjustmentSettingsController@show');
//Route::get('/admin/ajuste/config/editar', 'AdjustmentSettingsController@edit');
//Route::post('/admin/ajuste/config/editar', 'AdjustmentSettingsController@save');
//Route::get('/admin/ajuste', 'AdminAdjustmentsController@index');
//Route::post('/admin/ajuste/filtrar', 'AdminAdjustmentsController@filter');
//Route::post('/admin/ajuste/update', 'AdminAdjustmentsController@update');


//Route::get('/admin/certificados', 'AdminCertificatesController@index');

//Route::get('/admin/certificados/emitir', 'AdminCertificatesController@create');
//Route::post('/admin/certificados/emitir', 'AdminCertificatesController@store');

//Route::get('/admin/certificados/evento/{event}', 'AdminCertificatesController@certificates');


//Route::get('/admin/disciplinas', 'SubjectsController@index');
//Route::get('/admin/disciplinas/{subject}', 'SubjectsController@show');
//Route::get('/admin/disciplinas/{subject}/editar', 'SubjectsController@edit');
//Route::post('/admin/disciplinas/{subject}/salvar', 'SubjectsController@update');

//Route::post('/admin/estudantes/merge', 'AdminStudentsController@merge');
//Route::get('/admin/estudantes', 'AdminStudentsController@index');
//Route::get('/admin/estudante/{input}', 'StudentsController@find');
//Route::get('/admin/estudante/{student}/{email}', 'AdminStudentsController@update');

//Route::get('/admin/eventos/criar', 'EventsController@create');
//Route::get('/admin/eventos/configurar', 'AdminCertificatesController@configure');


//Route::get('/admin/evento/{event}', 'EventsController@show');
//Route::get('/admin/eventos', 'EventsController@index');
//Route::post('/admin/evento/criar', 'EventsController@store');
//Route::patch('/admin/evento/{event}', 'EventsController@update');
//Route::get('/admin/evento/{event}/editar', 'EventsController@edit');


//Route::get('/admin/templates', 'TemplatesController@index');
//Route::post('/admin/templates', 'TemplatesController@store');

//Route::get('/admin/usuarios', 'UsersController@show');
//Route::get('/admin/usuarios/criar', 'UsersController@create');
//Route::post('/admin/usuarios/criar', 'UsersController@store');


















