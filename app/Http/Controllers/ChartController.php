<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Monitoring;
use App\Models\Klasifikasi;
use App\Models\DataTraining;
class ChartController extends Controller
{   
    public function index(Request $request){
        $data = Monitoring::latest()->simplePaginate(10);

        $label = [];
        $suhu = [];
        $kelembaban = [];
        $ammonia = [];
        $kelas = [];
        foreach ($data as $chrt) {
            $label[] = $chrt->created_at->format('H:i:s');
            $suhu[] = $chrt->suhu;
            $kelembaban[] = $chrt->kelembaban;
            $ammonia[] = $chrt->ammonia;
            $kelas[] = $chrt->kelas;
        }
        return view('data.index', [
            'label' => $label,
            'suhu' => $suhu,
            'kelembaban' => $kelembaban,
            'ammonia' => $ammonia,
            'kelas' => $kelas,
            'data' => $data,
        ]);
    }

    
}

