<?php

use App\Subject;
use App\Setting;
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
Route::get('/', 'SpaController@index');

Route::post('/disciplinas', 'SubjectsController@subjects');

//Route::get('/certificado/validar', 'CertificatesController@hashValidator');
//Route::get('/certificado/validar/{hash}', 'CertificatesController@hashValidate');
Route::get('/certificado/validar', 'CertificatesController@hashValidator');

Route::middleware('student')->get('/subjects/{period}', function($period) {
	//$subjects = Subject::where('period', $period)->get();
	$subjects = Subject::fromPeriod($period);
	return response($subjects, 200);
});

Route::middleware('student')->get('/setting/max-ajustes', function() {
	$maxAjustes = Setting::where('nome', 'max_ajustes')->first()['valor'];
	return response($maxAjustes, 200);
});



//Auth::routes();































