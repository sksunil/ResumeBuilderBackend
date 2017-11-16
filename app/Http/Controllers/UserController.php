<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use App\User;
use JWTAuthException;

class UserController extends Controller
{
    private $user;
    public function __construct(User $user){
        $this->User = $user;
    }

    public function register(Request $request){
       $this->validate($request,[
         'name' =>'required|string|max:255',
         'email' =>'required|string|email|max:255|unique:users',
         'password' =>'required|string|min:6|confirmed',
       ]);

        $user = $this->User->create([
          'name' => $request->get('name'),
          'email' => $request->get('email'),
          'password' => bcrypt($request->get('password'))
        ]);

          return view('auth.login');
    //  return response()->json(['status'=>true,'message'=>'User created successfully','data'=>$user]);
    }

    public function login(Request $request){

      $this->validate($request,[
        'email' =>'required',
        'password' =>'required',
      ]);

//      dd($request);
        $credentials = $request->only('email', 'password');
        $token = null;

        try {
           if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['invalid_email_or_password'], 422);
           }
        } catch (JWTAuthException $e) {
            return response()->json(['failed_to_create_token'], 500);
        }

      //  return view('layouts.app');
        //return response()->json(compact('token','email'));

        return response()->json([
                 'token' => $token
        ], 200);
    }
    public function getAuthUser(Request $request){
        $user = JWTAuth::toUser($request->token);
        return response()->json(['result' => $user]);
    }
}
