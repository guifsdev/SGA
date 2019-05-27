<?php 

Route::post('/admin/estudantes/merge', 'AdminStudentsController@merge');
Route::get('/admin/estudantes', 'AdminStudentsController@index');
Route::get('/admin/estudante/{input}', 'StudentsController@find');
Route::get('/admin/estudante/{student}/{email}', 'AdminStudentsController@update');