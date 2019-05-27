<?php 


Route::get('/admin/certificados', 'AdminCertificatesController@index');
Route::get('/admin/certificados/emitir', 'AdminCertificatesController@create');
Route::post('/admin/certificados/emitir', 'AdminCertificatesController@store');
Route::get('/admin/certificados/{event}', 'AdminCertificatesController@certificates');


