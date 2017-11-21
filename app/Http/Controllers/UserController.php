<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use App\Http\Controllers\Controller;
use JWTAuth;
use App\User;
use JWTAuthException;
use Redirect;
use ValidatesRequests;

class UserController extends Controller
{
    private $user;
    public function __construct(User $user){
        $this->User = $user;
    }

    public function register(Request $request){

       $validator = Validator::make($request->all(),[
         'name' =>'required|string|max:255',
         'email' =>'required|string|email|max:255|unique:users',
         'password' =>'required|string|min:6|confirmed',
       ]);
       if ($validator->fails()) {
          //  return redirect()->back()->with('Invalid credentials...');
            return 'Invalid credentials...';
       }
       else {
         $user = $this->User->create([
           'name' => $request->get('name'),
           'email' => $request->get('email'),
           'password' => bcrypt($request->get('password'))
         ]);

           return "registration done...";
       }

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
            return response()->json(['Invalid email or password'], 422);
           }
        } catch (JWTAuthException $e) {
            return response()->json(['ailed to create token'], 500);
        }

       //return view('layouts.app');
        //return response()->json(compact('token','email'));

        return response()->json([
                 'token' => $token
        ], 200);
    }
    public function getAuthUser(Request $request){
        $user = JWTAuth::toUser($request->token);
        return response()->json(['result' => $user]);
    }

    public function userProfile()
    {

      $email = JWTAuth::parseToken()->toUser()->value('email');
      $Alldetails = User::where('email', '='  , $email)->get();
      $userName = $Alldetails['0']['attributes']['name'];
      $userEmail = $Alldetails['0']['attributes']['email'];
      $userDetails=['name'=>$userName,'email'=>$userEmail];

      return $userDetails;    // return user name and email id
    }
}
