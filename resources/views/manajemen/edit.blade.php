@extends('layouts.master')
@section('title', 'User')

@section('breadcrumbs')
<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Edit Data User</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="{{ url('main') }}">Home</a></li>
                            <li class="active">User</li>
                            <li class="active">Edit Data</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('content')
<div class="content mt-3">

            <div class="animated fadeIn">
                <div class="card">
                    <div class="card-header">
                        <div class="pull-left">
                            <strong>Edit Data </strong>
                        </div>
                        <div class="pull-right">
                            <a href="{{ url('user') }}" class="btn btn-secondary btn-sm">
                                <i class="fa fa-undo"></i>Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 offset-md-4">
                                <form action="{{ url('user/'.$user->id) }}" method="POST">
                                @method('put')  
                                    @csrf
                                    <div class="form-group">
                                        <label >Nama</label>
                                        <input type="text" name="nama_akun" class="form-control" value="{{ $user->nama }}" autofocus required>
                                    </div>
                                    <div class="form-group">
                                        <label >Username</label>
                                        <input type="text" name="username" class="form-control" value="{{ $user->username }}" autofocus required>
                                    </div>
                                    <div class="form-group">
                                        <label >Password</label>
                                        <input type="text" name="password" class="form-control" value="{{ $user->password }}" autofocus required>
                                    </div>
                                    <div class="form-group">
                                        <label >Level</label></br>
                                        <select  class="standardSelect"  name="level" > 
                                            <option value="{{ $user->level }}" >{{ $user->level }}</option> 
                                            <option value="admin" >ADMIN</option> 
                                            <option value="peternak" >PETERNAK</option> 
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-success">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- .content -->
@endsection