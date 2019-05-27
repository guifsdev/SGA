<?php 

Route::get('/admin/eventos/templates', 'TemplatesController@index');
Route::post('/admin/eventos/templates', 'TemplatesController@store');
Route::get('/admin/eventos/criar', 'EventsController@create');
Route::get('/admin/eventos/configurar', 'AdminCertificatesController@configure');


Route::get('/admin/evento/{event}', 'EventsController@show');
Route::get('/admin/eventos', 'EventsController@index');
Route::post('/admin/evento/criar', 'EventsController@store');
Route::patch('/admin/evento/{event}', 'EventsController@update');
Route::get('/admin/evento/{event}/editar', 'EventsController@edit');