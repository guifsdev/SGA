<?php 
Route::get('/admin/templates', 'TemplatesController@index');
Route::post('/admin/templates', 'TemplatesController@store');