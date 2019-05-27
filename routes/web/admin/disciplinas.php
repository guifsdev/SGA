<?php 

Route::get('/admin/disciplinas', 'SubjectsController@index');
Route::get('/admin/disciplinas/{subject}', 'SubjectsController@show');
Route::get('/admin/disciplinas/{subject}/editar', 'SubjectsController@edit');
Route::post('/admin/disciplinas/{subject}/salvar', 'SubjectsController@update');