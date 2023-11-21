@extends('layouts.master')
@section('title', 'Manajemen')

@section('breadcrumbs')
<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Data Periode</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="{{ url('main') }}">Home</a></li>
                            <li class="active">Manajemen</li>
                            <li class="active">Tambah Periode</li>
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
                            <strong>Tambah Periode </strong>
                        </div>
                        <div class="pull-right">
                            <a href="{{ url('manajemen') }}" class="btn btn-secondary btn-sm">
                                <i class="fa fa-undo"></i>Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 offset-md-4">
                                <form action="{{ url('manajemen') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label >Tanggal Masuk Ayam</label>
                                        <input type="date" name="masuk" class="form-control" autofocus required>
                                    </div>
                                    <div class="form-group">
                                        <label >Penanggung Jawab</label>
                                        <input type="text" name="pj" class="form-control" autofocus required>
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