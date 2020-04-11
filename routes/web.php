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


Route::get('down', function() {
	$password = request('password');
	$hash = '$2y$10$yY/Fbe0ZalyepNL8iNxGy.snGDRB/gxvHvtmTtp8UVHIEEVqjJy.S';
	$check = Illuminate\Support\Facades\Hash::check($password, $hash);

	if($check) {
		Illuminate\Support\Facades\Artisan::call('down');
	}
	else return response(['error' => 'Senha incorreta.'], 500);
})->middleware('auth:servant');

Route::get('/login', 'Auth\LoginController@showLoginForm');

Route::prefix('estudante')->group(function() {
	Route::post('login', 'StudentLoginController@login');
	Route::get('logout', 'StudentLoginController@logout');
	Route::get('/', 'StudentHomeController@home');

	Route::get('adjustment/index', 'StudentAdjustmentController@index');
	Route::post('adjustment/store', 'StudentAdjustmentController@store');

	Route::prefix('calls')->group(function() {
		Route::get('create', 'StudentCallsController@create');
		Route::post('/', 'StudentCallsController@store');
	});


	Route::prefix('certificados')->group(function() {
		Route::get('index', 'StudentCertifictesController@index');
		Route::get('show/{certificate}', 'StudentCertifictesController@show');
	});
});

Route::prefix('servidor')->group(function() {
	Route::post('login', 'ServantsLoginController@login');
	Route::get('logout', 'ServantsLoginController@logout');
	Route::get('/', 'ServantHomeController@home');

	Route::prefix('configs')->group(function() {
		Route::get('index', 'ServantConfigsController@index');
		Route::post('update', 'ServantConfigsController@update');
	});
	Route::prefix('calls')->group(function() {
		Route::get('index', 'ServantCallsController@index');
		Route::get('{call}/edit', 'ServantCallsController@edit');
	});

	Route::get('call/{call}/attachment/{attachment}', 'ServantAttachmentsController@show');

	Route::prefix('subjects')->group(function() {
		Route::get('index', 'ServantSubjectsController@index');
		Route::post('/', 'ServantSubjectsController@store');
	});

	Route::prefix('adjustments')->group(function() {
		Route::get('index', 'ServantAdjustmentController@index');

		Route::post('resolve', 'ServantAdjustmentController@resolve');
	});
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


















