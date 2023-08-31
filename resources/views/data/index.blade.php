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

                <div class="card">
                    <div class="card-header">
                        <div class="pull-left">
                            <strong>Monitoring Kandang</strong>
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
                                </tr>   
                            <tread>
                            <tbody>
                                @foreach($data as $key => $item)
                                <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->suhu }} Derajat Celsius</td>
                                <td>{{ $item->kelembaban }} %</td>
                                <td>{{ $item->ammonia }} ppm</td>
                                <td>{{ $label[$loop->index] }}</td>
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
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
            


        </div><!-- .content -->
        
    

        
@endsection

