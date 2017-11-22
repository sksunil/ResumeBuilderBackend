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
use Validator;

class ChangePassword extends Controller
{


  private static $random_number,$user;

  public function postReset(Request $request)
	{
	$validator = Validator::make($request->all(),[
			'email' => 'required|email',
      'password' => 'required',
			'new_password' => 'required_with:password_confirmation|min:6',
      'password_confirmation' =>'required|same:new_password',
		]);

   if ($validator->fails()) {
       //  return redirect()->back()->with('Invalid credentials...');
         return 'Invalid Credentials...';
       }
    else {

    $credentials = $request->only('email','password');

    if (!$token = JWTAuth::attempt($credentials)) {
     return response()->json(['Invalid email or password'], 422);
    }
    else
    {
    $new = $request->only('email','new_password');
     $email=$new['email'];
      $password = bcrypt($new['new_password']);
      //dd($password);
      User::where('email', '=' , $email)->update(array('password' => $password));
      return "Password Change sucessFully!";    //return login page
      //return redirect()->back();

    }
  }

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
