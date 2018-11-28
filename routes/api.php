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

Route::get('/user', function (Request $request) {
    return $request->user();
});
Route::post('login','AuthController@postLogin');
Route::get('logout','AuthController@getLogout');
Route::group(['prefix' => 'users'], function(){
	Route::get('edit', 'UserController@edit');
	Route::post('update', 'UserController@update');
});
Route::group(['prefix' => 'songs'], function(){
	Route::get('list', 'SongController@index');
});
Route::get('test','AuthController@testHeader');
