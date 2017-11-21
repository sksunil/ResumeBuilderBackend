<?php

use Illuminate\Http\Request;




Route::get('/display','ResumeController@index')->middleware('jwt'); // get all user data
Route::post('/insert','ResumeController@store')->middleware('jwt'); // store the data
Route::delete('/delete','ResumeController@destory')->middleware('jwt'); //delete the user data
Route::post('/update','ResumeController@update')->middleware('jwt');   // update the user data
Route::get('/templates','TemplateController@setUp')->middleware('jwt'); //Get all templates
Route::get('/userTemplates','ResumeController@userTemplates')->middleware('jwt'); // get templates of user


Route::post('/changePassword', [
  'uses' => 'ChangePassword@postReset',
  'middleware' => 'jwt'
]);

Route::get('/resetEmail','ChangePassword@sendMail');

Route::get('/userProfile', [
  'uses' => 'UserController@userProfile',
  'middleware' => 'jwt'
]);

Route::post('/register',[
  'uses' => 'UserController@register'
]);
Route::post('/login',[
  'uses' => 'UserController@login'

]);
