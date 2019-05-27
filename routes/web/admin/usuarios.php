<?php

Route::get('/admin/usuarios', 'UsersController@show');
Route::get('/admin/usuarios/criar', 'UsersController@create');
Route::post('/admin/usuarios/criar', 'UsersController@store');