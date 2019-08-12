<?php

use Illuminate\Http\Request;

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

Route::group(['prefix' => 'jenis_laporan'], function () {
    Route::get('/', "JenislaporanController@index");
    Route::get('/{id_jenislaporan}', "JenislaporanController@show");
    Route::post('/insert', "JenislaporanController@store");
    Route::put('/edit', "JenislaporanController@store");
    Route::get('/delete/{id_jenislaporan}', "JenislaporanController@destroy");
});

Route::group(['prefix' => 'user'], function () {
    Route::get('/', "UserController@list_user");
    Route::get('/polisi', "UserController@list_user_polisi");
    Route::get('/{userid}', "UserController@list_user_byid");
    Route::get('/verifikasi/{userid}', "UserController@verifikasi_user");
    Route::post('/insert', "UserController@add_user");
    Route::post('/login', "UserController@login_user");
});

Route::group(['prefix' => 'laporan'], function () {
    Route::get('/', "LaporanController@index");
    Route::post('/insert', "LaporanController@store");
    Route::get('/delete/{id_laporan}', "LaporanController@destroy");
    Route::get('/{id_laporan}', "LaporanController@show");
});
