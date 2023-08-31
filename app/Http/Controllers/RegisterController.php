<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Storage;
use File;
use Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Alert;
use App\Models\User;


class RegisterController extends Controller
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

    public function index(Request $request)
    {
        return view('register.index', [
            'username' => 'required',
            'password' => 'required',
        ]);
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|min:3|max:255|unique:users',
            'password' => 'required|min:5|max:255',
        ]);
        dd('asw');
        // $validatedData['password'] = Hash::make($validatedData['password']);

        // User::create($validatedData);
        // return redirect('login');
    }
}
