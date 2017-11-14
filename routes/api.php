<?php

use Illuminate\Http\Request;



Route::get('/Display','ResumeController@index');
Route::post('/insert', 'ResumeController@store');

Route::post('/update', [
  'uses' => 'ResumeController@update',
  'middleware' => 'jwt.auth'
]);

Route::post('auth/register', 'UserController@register');
Route::post('auth/login', 'UserController@login');

Route::post('/register',[
  'uses' => 'UserController@register'
]);
Route::post('/login',[
  'uses' => 'UserController@login'

]);
// Route::group(['middleware' => 'jwt.auth'], function () {
//     Route::get('user', 'UserController@getAuthUser');
// });
