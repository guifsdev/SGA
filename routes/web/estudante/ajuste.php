<?php 

//Route::post('/ajuste', 'AdjustmentsController@index');
//Route::post('/ajuste/confirmar', 'AdjustmentsController@confirm');
//Route::post('/ajuste/modificar', 'AdjustmentsController@modify');
Route::middleware('auth_student')->post('/ajuste/store', 'AdjustmentsController@store');

Route::get('/ajuste/status', 'AdjustmentsController@status');