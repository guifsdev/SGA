<?php

use Illuminate\Http\Request;
use App\Setting;
use App\Subject;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/admin/settings', function() {
	$lastMerged = Setting::where('nome', 'data_merged')->first();
    $lastMerged = $lastMerged ? $lastMerged['valor'] : 'nunca';

    return $lastMerged;
});
