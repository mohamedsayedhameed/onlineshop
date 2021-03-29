<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{

    public function getLogin(){
        return view('admin.auth.login');
    }

    public function login(LoginRequest $request){
        $remember_me = $request->has('remember_me') ? true : false;
        if(auth()->guard('admin')->attempt(['email'=>$request->input('email'),
                                            'password'=>$request->input('password')])){
            return redirect()->route('admin.dashboard');            
        }
        return redirect()->back()->with(['errors'=>'خطأ'])->withInput($request->all);
    }

    public function logout(){
        //auth()->logout();
        Auth::guard('admin')->logout();
        return redirect()->route('get.admin.login'); 
    }
}
