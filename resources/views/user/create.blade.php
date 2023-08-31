@extends('layouts.master')
@section('title', 'User')

@section('breadcrumbs')
<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Data User</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="{{ url('main') }}">Home</a></li>
                            <li class="active">User</li>
                            <li class="active">Tambah Data</li>
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
                            <strong>Tambah Data </strong>
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
                                <form action="{{ url('user') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label >Nama</label>
                                        <input type="text" name="nama_akun" class="form-control" autofocus required>
                                    </div>
                                    <div class="form-group">
                                        <label >Username</label>
                                        <input type="text" name="username" class="form-control" autofocus required>
                                    </div>
                                    <div class="form-group">
                                        <label >Password</label>
                                        <input type="password" name="password" class="form-control" autofocus required>
                                    </div>
                                    <div class="form-group">
                                        <label >Level</label></br>
                                        <select  class="form-control"  name="level" autofocus required> 
                                            <option value="" >- Pilih Role -</option> 
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