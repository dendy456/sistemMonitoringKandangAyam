
@extends('layouts.user')
@section('title', 'Home')

@section('breadcrumbs')
<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>HOME</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="{{ url('home') }}">Home</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('content')

            <div class="animated fadeIn">
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif
                <div class="sufee-login d-flex align-content-center flex-wrap">
                    <div class="container">
                        <div class="login-content">
                            <div class="login-logo">
                                <a href="">
                                    <img class="align-content" src="{{ asset('style/images/ayamLogo.png') }}" alt="">
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="mx-auto d-block">
                                    
                                    <h5 class="text-sm-center mt-2 mb-1">Sistem Monitoring Kandang Ayam </h5>
                                    <div class="location text-sm-center"><i class="fa fa-map-marker"></i> PT. Mutiara Sinar Abadi</div>
                                </div>
                                <hr>
                                <div class="card-text text-sm-center">
                                    <a href="#"><i class="fa fa-facebook pr-1"></i></a>
                                    <a href="#"><i class="fa fa-twitter pr-1"></i></a>
                                    <a href="#"><i class="fa fa-linkedin pr-1"></i></a>
                                    <a href="#"><i class="fa fa-pinterest pr-1"></i></a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

@endsection