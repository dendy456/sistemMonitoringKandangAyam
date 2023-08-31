<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Hash;

class UserController extends Controller
{
//     public function __construct()
// {
//     $this->middleware('admin');
// }
    public function index()
    {
        $user = User::simplePaginate(5);

        return view('user.index')
        ->with('user',$user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $username = $request->input('username');
        $cari = User::where('username', '=', $username)->get();
        if($cari->count())
        {
            return back();
        }

        $user = new User;
        $user->username     = $request->input('username');
        $user->password     = Hash::make($request->input('password'));
        $user->nama    = $request->input('nama_akun');
        $user->level        = $request->input('level');
        
        $user->save();
        return redirect('user');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('user',$user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        return view('user.edit')
        ->with('user',$user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $username = $request->input('username');
        $cari = User::where('username', '=', $username)->get(); 
        $user = User::find($id);

        if($user->username == $username ){
            $user->username     = $request->input('username');
            $user->password     = Hash::make($request->input('password'));
            $user->nama    = $request->input('nama_akun');
            $user->level        = $request->input('level');
            
            $user->save();
            return redirect('user');
        }else if($cari->count()){
            return back();
        }else{
            $user->username     = $request->input('username');
            $user->password     = Hash::make($request->input('password'));
            $user->nama    = $request->input('nama_akun');
            $user->level        = $request->input('level');
            
            $user->save();
            return redirect('user');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('user');
    }
}
