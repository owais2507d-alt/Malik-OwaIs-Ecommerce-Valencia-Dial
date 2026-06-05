<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
   public function showRegister(){
    return view('auth.register');
   } 
//// register logic 
   public function  Register(Request $request){
           
       $request->validate([
        'name'=>'required|string|max:255',
        'email'=>'required|string|max:255|unique|users',
        'password'=>'required|string|min:6|confirmed'
       ]);

       /// user creation
       $user =User::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>Hash::make($request->password),
        'role'=>'customer'
       ]); 
   }
   public function showLogin(){
    return view('auth.login');
   }
/// login process logic 
   public function login(Request $request){
    $credentials =$request->validate([
        'email'=>'required|email',
        'passowrd'=>'required'
    ]);
    if(Auth::attempt($credentials ,$request->remember)){
        $request->session()->regenerate();
    }
    

   }
   
}
