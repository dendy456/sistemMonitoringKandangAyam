<?php

namespace App\Http\Controllers;

use App\Models\Monitoring;
use App\Models\DataTraining;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
class KlasifikasiController extends Controller
{
    public function index()
    {   
        $monitoring = Monitoring::latest()->limit(10)->get();
        $label= [];
        $suhu= [];
        $kelembaban= [];
        $ammonia= [];
        foreach($monitoring as $chrt){
            $label[]= $chrt->created_at->format('H:i:s');
            $suhu[]= $chrt->suhu;
            $kelembaban[]= $chrt->kelembaban;
            $ammonia[] = $chrt->ammonia;
            $kelas = $chrt->kelas;
        }
       
        return view('klasifikasi.index', ['label' => $label,'suhu' => $suhu,'kelembaban' => $kelembaban,'ammonia' => $ammonia, 'kelas' => $kelas]);
    }

    public function ceksuhu()
    {
        $klasifikasi = Monitoring::latest()->limit(1)->get();

        foreach($klasifikasi as $item){
            $suhu = $item->suhu;
        }
        return $suhu;
    }

    public function cekkelembaban()
    {
        $klasifikasi = Monitoring::latest()->limit(1)->get();
        foreach($klasifikasi as $item){
            $kelembaban = $item->kelembaban;
        }
        return $kelembaban;
    }

    public function cekammonia()
    {
        $klasifikasi = Monitoring::latest()->limit(1)->get();
        foreach($klasifikasi as $item){
            $ammonia = $item->ammonia;
        }
        return $ammonia;
    }

    public function cekkelas(Request $request)
    {
        $klasifikasi = Monitoring::latest()->limit(1)->get();
        foreach($klasifikasi as $item){
            $kelas = $item->kelas;
        }
        return $kelas;
    }

    public function cekgrafik()
    {
        $monitoringData = Monitoring::latest()->take(10)->get();
        $dataLast = Monitoring::latest()->first();
        $labels = [];
        // Konversi waktu dalam bentuk (Jam:Menit)
        foreach ($monitoringData as $date) {
            $formattedDate = $date->created_at->format('H:i');
            $labels[] = $formattedDate;
        }
        $suhu = $monitoringData->pluck('suhu');
        $kelembaban = $monitoringData->pluck('kelembaban');
        $ammonia = $monitoringData->pluck('ammonia');
        $nilai_last_suhu = $dataLast->suhu;
        $nilai_last_kelembaban = $dataLast->kelembaban;
        $nilai_last_ammonia = $dataLast->ammonia;
       
        return response()->json(compact('labels', 'ammonia', 'suhu', 'kelembaban', 'nilai_last_ammonia', 'nilai_last_suhu', 'nilai_last_kelembaban'));
    
    }

    public function coba(Request $request)
    {
        $datatraining = DataTraining::all();
        
        $dataUji= [];
        $dataTraining= [];
        foreach($datatraining as $dt){
            $Training=[$dt->suhu,$dt->kelembaban,$dt->ammonia,$dt->kelas];
            $dataTraining[]=$Training;
        }
        return view('klasifikasi.cekgrafik', ['dataTraining' => $dataTraining]);
    }

    
    

}
