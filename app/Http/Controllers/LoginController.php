<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\User;
use Storage;
use File;
use Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Alert;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */


    public function login()
    {
        if(Auth::check()){
            if(Auth::user()->level == "admin" ){
                return redirect()->intended('/main');
            }else{
                return redirect()->intended('/home');
            }
     }else{
        return view('auth.login');
     }
 }

 public function doLogin(Request $request)
 {

    $validator = Validator::make($request->all(), [
        'username' => 'required',
        'password' => 'required',
    ]);

    if ($validator->fails()) {
        return back()
        ->withErrors($validator)
        ->withInput();
    } else {

        $userdata = array(
            'username'     => $request->input('username'),
            'password'  => $request->input('password')
        );

        if (Auth::attempt($userdata)) {
            alert()->success('Berhasil Login', 'Success!');
            if(Auth::user()->level == "admin" ){
                return redirect()->intended('/main');
            }elseif(Auth::user()->level == "peternak" ){
                return redirect()->intended('/home');
            }else{
                abort(403, 'Unauthorized action.');
            }

        } else {        
            
            return back()->with('status', 'Login Gagal! Silahkan Cek atau Lakukan Registrasi');
            
        }

    }
}

  
    public function logout(){

        Auth::logout();
        alert()->success('Berhasil Logout', 'Success!');
        return redirect('login');
    }
}