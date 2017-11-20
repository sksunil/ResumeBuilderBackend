<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use App\Http\Controllers\ChangePassword;
use App\User;
use Illuminate\Auth\Passwords\CanResetPassword;
use Mail;
use JWTAuthException;

class ChangePassword extends Controller
{
  public function postReset(Request $request)
	{
		$this->validate($request, [
			'token' => 'required',
			'email' => 'required|email',
			'password' => 'required|confirmed',
		]);

		$credentials = $request->only(
			'email', 'password', 'password_confirmation', 'token'
		);

      $email=$credentials['email'];
      $password = bcrypt($credentials['password']);
      User::where('email', '=' , $email)->update(array('password' => $password));
      return "Password Change sucessFully!";    //return login page

    }


    public function otp(){

            $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) ); //
            echo $random_number;

        }

        public function sendMail()
        {

            Mail::send(['text'=>'MailDetails'],['name','SAndy'],function($message)
              {
                     $message->to('sksunilkumawat1995@gmail.com','hello hown you')->subject('test mail');
                      $message->from('sksunilkumawat1995@gmail.com','SAndy');
              }
          );

       }

	}
