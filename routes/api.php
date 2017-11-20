<?php

use Illuminate\Http\Request;




Route::get('/display','ResumeController@index')->middleware('jwt'); // get all user data
Route::post('/insert','ResumeController@store')->middleware('jwt'); // store the data
Route::delete('/delete','ResumeController@destory')->middleware('jwt'); //delete the user data
Route::patch('/update','ResumeController@update')->middleware('jwt');   // update the user data
Route::get('/templates','TemplateController@setUp')->middleware('jwt'); //Get all templates
Route::get('/userTemplates','ResumeController@userTemplates')->middleware('jwt'); // get templates of user
// Route::get('/display', [
//   'uses' => 'ResumeController@index',
//   'middleware' => 'jwt.auth'
// ]); // get all user data
//
// Route::post('/insert', [
//   'uses' => 'ResumeController@store',
//   'middleware' => 'jwt.auth'
// ]); // store the data
//
// Route::delete('/delete', [
//   'uses' => 'ResumeController@destory',
//   'middleware' => 'jwt.auth'
// ]); //delete the user data
//
// Route::patch('/update', [
//   'uses' => 'ResumeController@update',
//   'middleware' => 'jwt.auth'
// ]);// update the user data
//
// Route::get('/templates', [
//   'uses' => 'TemplateController@setUp',
//   'middleware' => 'jwt.auth'
// ]);
//
// Route::get('/userTemplates', [
//   'uses' => 'ResumeController@userTemplates',
//   'middleware' => 'jwt.auth'
// ]); // get templates of user

Route::post('/changePassword', [
  'uses' => 'ChangePassword@postReset',
  'middleware' => 'jwt.auth'
]);

Route::get('/resetEmail','ChangePassword@sendMail');

Route::get('/userProfile', [
  'uses' => 'UserController@userProfile',
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
