@extends('layouts.master')

@section('title', 'Manajemen')

@section('breadcrumbs')
<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Manajemen Kandang</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="{{ url('main') }}">Home</a></li>
                            <li class="active">Manajemen Kandang</li>
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
                            <strong>Manajemen Kandang</strong>
                        </div>
                        <div class="pull-right">
                            <a href="{{ url('manajemen/create') }}" class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i>Periode
                            </a>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered">
                            <tread>
                                <tr>
                                    <th>No.</th>
                                    <th>Periode</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Tanggal Panen</th>
                                    <th>Umur Ayam</th>
                                    <th>Penanggung Jawab</th>
                                    <th>Action</th>
                                </tr>   
                            <tread>
                            <tbody>
                                @foreach($data as $key => $item)
                                <tr>
                                <td>{{ $data->firstItem() + $key }}</td>
                                <td>Tahun {{ $item->periode }}</td>
                                <td>{{ $item->tanggal_masuk }} </td>
                                <td>{{ $item-> tanggal_panen }} </td>
                                <td>
                                    @if($item->umur_ayam !== null)
                                        {{ $item->umur_ayam }} Hari
                                    @else
                                        {{ $umur }} Hari
                                    @endif
                                </td>
                                <td>{{ $item->pj }}</td>
                                    <td class="text-center">
                                    <form action="{{ url('manajemen/'.$item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin untuk menghapus data ?')">
                                        <a href="{{ url('manajemen/'.$item->id.'/edit') }}" class="btn btn-primary btn-sm">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="{{ url('manajemen/'.$item->id.'/panen') }}" class="btn btn-success btn-sm">
                                            <i class="fa fa-check"> Panen</i>
                                        </a>
                                        
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

