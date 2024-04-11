<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function index(){
      return view('admin.login');
    }
    public function authenticateUser(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);


        if (Auth::guard('admin')->attempt(['email'=> $request->email, 'password' => $request->password], $request->get('remember'))) {

          $admin = Auth::guard('admin')->user();

          if($admin->role == 1){
            // Authentication successfull
            return redirect()->route('admin.dashboard')->with('success','You have registered successfully'); 
          }else{
            $admin = Auth::guard('admin')->logout();
            return back()->with('error','You are not authorized to access to admin panel !!');
          }        
  }
    // Authentication failed
    return back()->with('error','Invalid Credential !!');
    }
     public function Logout () {
      Auth::guard('admin')->logout();
      return redirect()->route('admin.login'); 
     }
}