<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Monitoring;
use App\Models\Manajemen;
use App\Models\DataTraining;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ManajemenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Manajemen::simplePaginate();
        $waktu = Manajemen::latest()->get();
        $jumlahHari=null;
        foreach ($waktu as $dt) {
            if(is_null($dt->umur_ayam)){
                $tanggalMasuk = Carbon::parse($dt->tanggal_masuk);

                // Ambil tanggal sekarang
                $tanggalSekarang = Carbon::now();

                // Hitung selisih hari
                $jumlahHari = $tanggalMasuk->diffInDays($tanggalSekarang);
            }
        }
        // $request->validate([
        //     'tanggal_masuk' => 'required|date',
        // ]); //pengambilan data dari umur ayam
        
        return view('manajemen.index', [
            'umur' => $jumlahHari,
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manajemen.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new Manajemen;
        $dateNow = date("Y");
        $data->tanggal_masuk     = $request->input('masuk');
        $data->pj    = $request->input('pj');
        $data->periode        = $dateNow;
        
        $data->save();
        return redirect('manajemen');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Manajemen::find($id);
        $user->delete();
        return redirect('manajemen');
    }

    public function panen($id)
    {
        
        $data = Manajemen::find($id);
        $tanggalMasuk = Carbon::parse($data->tanggal_masuk);
        // Ambil tanggal sekarang
        $tanggalSekarang = Carbon::now();
        // Hitung selisih hari
        $jumlahHari = $tanggalMasuk->diffInDays($tanggalSekarang);
        $dateNow = date("Y-m-d");
        $data->tanggal_panen    = $dateNow;
        $data->umur_ayam        = $jumlahHari;
        $data->save();
        return redirect('manajemen');
    }
}
