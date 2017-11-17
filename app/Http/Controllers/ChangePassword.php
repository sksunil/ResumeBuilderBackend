<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use App\Http\Controllers\ChangePassword;
use App\User;
use Illuminate\Auth\Passwords\CanResetPassword;
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


// public function sendMail()
// {
// $to = 'harshadakhani8882@gmail.com';
// $subject = 'My subject';
// $txt = 'Hello world!';
// $headers = 'From: sksunilkumawat1995@gmail.com';
// $d=mail($to,$subject,$txt,$headers);
// dd($d);
// }


	}
