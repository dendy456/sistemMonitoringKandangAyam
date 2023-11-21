<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Monitoring;
use App\Models\Klasifikasi;
use App\Models\DataTraining;
use App\Models\DataTraining2;
use App\Models\DataTraining3;
use App\Models\DataTraining4;
use App\Models\DataTraining5;
use App\Models\Manajemen;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use App\Exports\DataMonitoring;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

require_once('Helpers.php');
class ChartController extends Controller
{   
    public function index(Request $request){
        $data = Monitoring::latest()->simplePaginate();

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

    public function search(Request $request)
    {
        $tanggal = $request->input('tanggal');

        $data = Monitoring::whereDate('created_at', '=', $tanggal)->get();
        return view('data.search', [
            'cariTanggal' => $tanggal,
            'data' => $data,
        ]);
    }

    public function sorting(Request $request)
    {
        
        $waktu = Manajemen::get();
        $jumlahHari=null;
        $umur = 0;
        $datatraining = DataTraining::select('suhu', 'kelembaban', 'ammonia', 'kelas')->get();
        foreach ($waktu as $dt) {
            
            if(is_null($dt->umur_ayam)){
                
                $tanggalMasuk = Carbon::parse($dt->tanggal_masuk);

                // Ambil tanggal sekarang
                $tanggalSekarang = Carbon::now();

                // Hitung selisih hari
                $jumlahHari = $tanggalMasuk->diffInDays($tanggalSekarang);
                if($jumlahHari < 8){
                    $datatraining = DataTraining::select('suhu', 'kelembaban', 'ammonia', 'kelas')->get();
                }elseif($jumlahHari < 15 && $jumlahHari >= 8){
                    $datatraining = DataTraining2::select('suhu', 'kelembaban', 'ammonia', 'kelas')->get();
                }elseif ($jumlahHari < 22 && $jumlahHari >= 15) {
                    $datatraining = DataTraining3::select('suhu', 'kelembaban', 'ammonia', 'kelas')->get();
                }elseif ($jumlahHari < 29 && $jumlahHari >= 22) {
                    $datatraining = DataTraining4::select('suhu', 'kelembaban', 'ammonia', 'kelas')->get();
                }elseif ($jumlahHari >= 29 ) {
                    $datatraining = DataTraining5::select('suhu', 'kelembaban', 'ammonia', 'kelas')->get();
                }
            }
        }
        $dataUji= [];
        $dataTraining= [];
        $kelas= [];
        $datauji = Monitoring::latest()->simplePaginate(10);
        $k = $request->input('k');

        //normalisasi datatraining
        function min_max_normalization($data) {
            $min = $data->min();
            $max = $data->max();
            $normalized_data = $data->map(function ($value) use ($min, $max) {
                return ($value - $min) / ($max - $min);
            });
        
            return $normalized_data;
        }
        $suhu_normalized = min_max_normalization($datatraining->pluck('suhu'));
        $kelembaban_normalized = min_max_normalization($datatraining->pluck('kelembaban'));
        $ammonia_normalized = min_max_normalization($datatraining->pluck('ammonia'));

        
        
        foreach ($datatraining as $key => $row) {
            $dataTraining[] = [
                $suhu_normalized[$key],$kelembaban_normalized[$key],$ammonia_normalized[$key],$row->kelas,
            ];
        }
        

        // Parameter min dan max yang dihitung dari data pelatihan
        $min_suhu = $datatraining->pluck('suhu')->min();
        $max_suhu = $datatraining->pluck('suhu')->max();

        $min_kelembaban = $datatraining->pluck('kelembaban')->min();
        $max_kelembaban = $datatraining->pluck('kelembaban')->max();

        $min_ammonia = $datatraining->pluck('ammonia')->min();
        $max_ammonia = $datatraining->pluck('ammonia')->max();

        // Normalisasi Min-Max untuk data uji
        foreach ($datauji as $uji) {
            $ujiSuhu = ($uji["suhu"] - $min_suhu) / ($max_suhu - $min_suhu);
            $ujiKelembaban = ($uji["kelembaban"] - $min_kelembaban) / ($max_kelembaban - $min_kelembaban);
            $ujiAmmonia = ($uji["ammonia"] - $min_ammonia) / ($max_ammonia - $min_ammonia);
            $dataUji[]= [$ujiSuhu,$ujiKelembaban,$ujiAmmonia];
            
        }

        
        
        foreach($dataUji as $data){
            $kelas[] = klasifikasi($data,$k,$dataTraining);
        }

        

        return view('klasifikasi.knn', [
            'kelas' => $kelas,
            'data' => $datauji,
            'k' => $k,
            'umur'=>$umur,
        ]);
    }
    private function getData()
    {
        $url = "https://platform.antares.id:8443/~/antares-cse/cnt-EyYTds4H786ZE5g1";
        $headers = [
            "X-M2M-Origin:d62b58a24f685c68:e294312a591f2234"
        ];

        // Memasukan header
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        curl_close($ch);
        // Mengubah format json ke array assosiative
        $dataJson = json_decode($response, true);
        
        return $dataJson['m2m:cin']['con'];
    }
    public function testing(Request $request)
    {
        
        $dataUji= [];
        $dataTraining= [];
        $kelas= [];
        $datatraining = DataTraining::select('suhu', 'kelembaban', 'ammonia', 'kelas')->get();
        $k = $request->input('k');
        $suhu = $request->input('suhu');
        $kelembaban = $request->input('kelembaban');
        $ammonia= $request->input('ammonia');

        //normalisasi datatraining
        function min_max_normalization($data) {
            $min = $data->min();
            $max = $data->max();
            $normalized_data = $data->map(function ($value) use ($min, $max) {
                return ($value - $min) / ($max - $min);
            });
        
            return $normalized_data;
        }
        $suhu_normalized = min_max_normalization($datatraining->pluck('suhu'));
        $kelembaban_normalized = min_max_normalization($datatraining->pluck('kelembaban'));
        $ammonia_normalized = min_max_normalization($datatraining->pluck('ammonia'));

        
        
        foreach ($datatraining as $key => $row) {
            $dataTraining[] = [
                $suhu_normalized[$key],$kelembaban_normalized[$key],$ammonia_normalized[$key],$row->kelas,
            ];
        }
        

        // Parameter min dan max yang dihitung dari data pelatihan
        $min_suhu = $datatraining->pluck('suhu')->min();
        $max_suhu = $datatraining->pluck('suhu')->max();
        
        $min_kelembaban = $datatraining->pluck('kelembaban')->min();
        $max_kelembaban = $datatraining->pluck('kelembaban')->max();

        $min_ammonia = $datatraining->pluck('ammonia')->min();
        $max_ammonia = $datatraining->pluck('ammonia')->max();

        // Normalisasi Min-Max untuk data uji
            $ujiSuhu = ($request->input('suhu') - $min_suhu) / ($max_suhu - $min_suhu);
            $ujiKelembaban = ($request->input('kelembaban') - $min_kelembaban) / ($max_kelembaban - $min_kelembaban);
            $ujiAmmonia = ($request->input('ammonia') - $min_ammonia) / ($max_ammonia - $min_ammonia);
            $dataUji[]= [$ujiSuhu,$ujiKelembaban,$ujiAmmonia];

        
        
        foreach($dataUji as $data){
            $kelas = klasifikasi($data,$k,$dataTraining);
        }
        ddd($this->getData());
        $data = json_decode($this->getData(), true);
        
        $ceksuhu= $data['temperature'];
        $cekkelembaban= $data['humidity'];
        $cekamonia = $data['amonia'];
        

        return view('klasifikasi.cekGrafik', [
            'kelas_prediksi' => $kelas,
            'suhu' => $ceksuhu,
            'kelembaban' => $cekkelembaban,
            'ammonia' => $cekamonia,
            'k' => $k,
        ]);
        
    }



    
    
    public function downloadExcel($cariTanggal)
    {
        return Excel::download(new DataMonitoring($cariTanggal), 'dataMonitoring.xlsx');
    }


    public function destroy($id_monitoring)
    {
        $user = Monitoring::find($id_monitoring);
        $user->delete();
        return redirect('monitoring');
    }
}

    


