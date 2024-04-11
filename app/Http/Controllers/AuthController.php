<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class AuthController extends Controller
{
    public function register(){
        return view('front.account.register');
    }
    public function login(){
        return view('front.account.login');
    }
   
    public function authenticate(Request $req){
       $req->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        if (Auth::attempt(['email'=> $req->email, 'password' => $req->password], $req->get('remember'))) {
            session()->flash('success', 'You login  successfully');
            if(session()->has('url.intended')){
                return redirect(session()->get('url.intended'));
            }
return redirect()->route('user.account');
        }else{
            session()->flash('error', 'Inavlid Credential');
            return redirect()->route('account.login');
        }
    }
public function Profile(){
    return view('front.account.profile');
}
public function Logout(){
    Auth::Logout();
    return redirect()->route('account.login')->with('success', 'You Successfully logged out!');
}

    
}