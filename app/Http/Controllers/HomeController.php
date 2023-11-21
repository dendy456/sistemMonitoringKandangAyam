<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manajemen;
use Carbon\Carbon;

class HomeController extends Controller
{
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
        return view('home', [
            'umur' => $jumlahHari,
            'data' => $data,
        ]);
    }
}
