<?php 

Route::post('/estudante/login', 'StudentAuth\StudentAuthController@login');
Route::get('/estudante/login', 'StudentAuth\StudentAuthController@showLoginForm');
Route::get('/estudante/logout', 'StudentAuth\StudentAuthController@logout');
Route::patch('/estudante/update', 'StudentsController@update');
Route::post('/estudante/certificados', 'StudentsController@certificates');


Route::get('/estudante/', 'SpaController@index');
Route::get('/estudante/{any}', 'SpaController@index')->where('any', '.*');




/*Route::get('/estudante', 'DashboardController@index');
Route::patch('/estudante', 'StudentsController@update');
Route::post('/estudante/home', 'DashboardController@home')->name('home');
Route::post('/estudante/dados', 'DashboardController@dados');
Route::post('/estudante/ajuste', 'DashboardController@ajuste');
Route::get('/estudante/login', 'StudentAuth\StudentAuthController@showLoginForm');
Route::post('/estudante/login', 'StudentAuth\StudentAuthController@login');
Route::get('/estudante/logout', 'StudentAuth\StudentAuthController@logout');*/