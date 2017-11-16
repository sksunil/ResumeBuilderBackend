<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use App\Http\Controllers\ForgotPassword;
use App\User;
use Illuminate\Auth\Passwords\CanResetPassword;
use JWTAuthException;

class ForgotPassword extends Controller
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
      return "sucess!";  

    }


	}
