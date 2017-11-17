<?php

use Illuminate\Http\Request;



Route::get('/display','ResumeController@index');
Route::post('/insert', 'ResumeController@store');
Route::delete('/delete', 'ResumeController@destory');
Route::patch('/update','ResumeController@update');
Route::get('/templates','TemplateController@setUp');
Route::post('/userTemplates','ResumeController@userTemplates');

Route::post('/update', [
  'uses' => 'ResumeController@update',
  'middleware' => 'jwt.auth'
]);

Route::post('/forgotPassword', [
  'uses' => 'ForgotPassword@postReset',
  'middleware' => 'jwt.auth'
]);

// Route::post('auth/register', 'UserController@register');
// Route::post('auth/login', 'UserController@login');

Route::post('/register',[
  'uses' => 'UserController@register'
]);
Route::post('/login',[
  'uses' => 'UserController@login'

]);
// Route::group(['middleware' => 'jwt.auth'], function () {
//     Route::get('user', 'UserController@getAuthUser');
// });
