<?php

use Illuminate\Http\Request;




Route::get('/display','ResumeController@index')->middleware('jwt'); // get all user data
Route::post('/insert','ResumeController@store')->middleware('jwt'); // store the data
Route::delete('/delete','ResumeController@destroy')->middleware('jwt'); //delete the user data
Route::patch('/update','ResumeController@update')->middleware('jwt');   // update the user data
Route::get('/templates','TemplateController@setUp')->middleware('jwt'); //Get all templates
Route::get('/userTemplates','ResumeController@userTemplates')->middleware('jwt'); // get templates of user

//sk
Route::post('/changePassword', [
  'uses' => 'ChangePassword@postReset',
  'middleware' => 'jwt'
]);

Route::post('/updatePassword','ChangePassword@updatePassword');
Route::get('/resetEmail','ChangePassword@sendMail');  //sk
Route::post('/sendOtp','ChangePassword@isExist');     //sk

Route::get('/userProfile', [                           //sk
  'uses' => 'UserController@userProfile',
  'middleware' => 'jwt'
]);

Route::post('/register',[                          //sk
  'uses' => 'UserController@register'
]);
Route::post('/login',[                              //sk
  'uses' => 'UserController@login'

]);
