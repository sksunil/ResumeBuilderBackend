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


  private static $random_number,$user;

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


    public static function otp(){

          return ChangePassword::$random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) ); //


        }
  //    public $mail;
        public function sendMail(String $email)
        {
          ChangePassword::$user = new User;
          ChangePassword::$user->email=$email;
            Mail::send(['text'=>'MailDetails'],['name','CVMaker'],function($message)
              {

                     $message->to(ChangePassword::$user['attributes']['email'],'User')->subject('Password Reset mail');
                      $message->from('cvmaker3911@gmail.com','CVMakerTeam');
              }
          );

       }

     public function isExist(Request $request){                          //IsExist method
       $email=$request->get('email');
       $Exist = User::where('email', '='  , $email)->get();
       $arr = json_decode($Exist,true);
      if(empty($arr))
       {
         return "Please Enter Valid Invalid Email Id.";
        }
       else {
             ChangePassword::sendmail($email);
             dd(ChangePassword::$random_number);            //otp for chacking
       }

 }
}
