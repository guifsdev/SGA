<?php 

Route::get('/admin/ajuste/config', 'AdjustmentSettingsController@show');
Route::get('/admin/ajuste/config/editar', 'AdjustmentSettingsController@edit');
Route::post('/admin/ajuste/config/editar', 'AdjustmentSettingsController@save');
Route::get('/admin/ajuste', 'AdminAdjustmentsController@index');
Route::post('/admin/ajuste/filtrar', 'AdminAdjustmentsController@filter');
Route::post('/admin/ajuste/update', 'AdminAdjustmentsController@update');