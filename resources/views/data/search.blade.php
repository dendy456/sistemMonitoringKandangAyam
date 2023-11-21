@extends('layouts.user')

@section('title', 'Monitoring')

@section('breadcrumbs')
<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Monitoring Kandang</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="{{ url('home') }}">Home</a></li>
                            <li class="active">Monitoring Kandang</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('content')
   
<div class="content mt-3">

            <div class="animated fadeIn">
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                
                @endif
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 offset-md-4">
                        <form action="{{ route('Search') }}" method="GET">
                            <div class="row form-group">
                                <div class="col col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-btn">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-search"></i> Search
                                        </button>
                                        </div>
                                        <input type="date" name="tanggal" id="tanggal" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="pull-left">
                            <strong>Monitoring Kandang</strong>
                        </div>
                        <div class="pull-right">
                        <a href="{{ url('download/'.$cariTanggal) }}" class="btn btn-success btn-sm">
                            <i class="fa fa-download">  Unduh Data Excel</i>
                        </a>
                        
                        
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered">
                            <tread>
                                <tr>
                                    <th>No.</th>
                                    <th>Suhu</th>
                                    <th>Kelembaban</th>
                                    <th>Kadar Gas Ammonia</th>
                                    <th>Waktu</th>
                                    <th>kelas</th>
                                    <th>{{ $cariTanggal }}</th>
                                </tr>   
                            <tread>
                            <tbody>
                                @foreach($data as $key => $item)
                                <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->suhu }} Derajat Celsius</td>
                                <td>{{ $item->kelembaban }} %</td>
                                <td>{{ $item->ammonia }} ppm</td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->kelas }}</td>
                                    <td class="text-center">
                                        <form action="{{ url('monitoring/destroy/'.$item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin untuk menghapus data ?')">
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                              
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
            


        </div><!-- .content -->
        
    

        
@endsection

