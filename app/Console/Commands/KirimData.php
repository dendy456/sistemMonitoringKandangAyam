<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Monitoring;
use App\Models\DataTraining;
use App\Models\Manajemen;


class KirimData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:log';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */

    private function getData()
    {
        $url = "https://platform.antares.id:8443/~/antares-cse/antares-id/KandangAyam_Bantuas/Data1/la";
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
        
        return $dataJson['m2m:cin'];
    }
    private function getKelas($suhu,$kelembaban,$ammonia)
    {
        //penentuan umur ayam
        $waktu = Manajemen::get();
        $jumlahHari=null;
        $umur = 0;
        $datatraining = DataTraining::select('suhu', 'kelembaban', 'ammonia', 'kelas')->get();
        foreach ($waktu as $dt) {
            //penentuan datatraining yang digunakan
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

        $dataUji= [];
        $dataTraining= [];
        
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
        $ujiSuhu_normalized = ($suhu - $min_suhu) / ($max_suhu - $min_suhu);
        $ujiKelembaban_normalized = ($kelembaban - $min_kelembaban) / ($max_kelembaban - $min_kelembaban);
        $ujiAmmonia_normalized = ($ammonia - $min_ammonia) / ($max_ammonia - $min_ammonia);

        $dataUji= [$ujiSuhu_normalized,$ujiKelembaban_normalized,$ujiAmmonia_normalized];
        function euclideanDistance($data1, $data2)
        {
            $sum = 0;
            for ($i = 0; $i < count($data1); $i++) {
                $sum += pow(($data1[$i] - $data2[$i]), 2);
            }
            return sqrt($sum);
        }

        // Fungsi untuk menghitung kelas terbanyak dari tetangga terdekat
        function getMostFrequentClass($classes)
        {
            $classCounts = array_count_values($classes);
            arsort($classCounts);
            return array_keys($classCounts)[0];
        }

        // Data uji
        $testData = array( $dataUji );
            

        // K value
        $k = 3;


        // Membaca data training dari hasil query
        $trainingData = $dataTraining;
        
        // Hitung jarak antara data uji dan data training
        $distances = array();
        foreach ($trainingData as $train) {
            $dist = euclideanDistance(array_slice($train, 0, -1), end($testData));
            $distances[] = array($train, $dist);
        }

        // Urutkan jarak dari yang terkecil
        usort($distances, function ($a, $b) {
            return $a[1] <=> $b[1];
        });

        // Ambil k tetangga terdekat
        $neighbors = array_slice($distances, 0, $k);

        // Ambil kelas dari tetangga terdekat
        $neighborClasses = array();
        foreach ($neighbors as $neighbor) {
            $neighborClasses[] = $neighbor[0][3];
        }

        // Prediksi kelas data uji berdasarkan kelas terbanyak dari tetangga terdekat
        $predictedClass = getMostFrequentClass($neighborClasses);
        return $predictedClass;
    }

    public function handle()
    {
        $dataJson = $this->getData();
        $data = json_decode($dataJson['con'], true);
        $suhu= number_format($data['temperature'], 2);
        $kelembaban= number_format($data['humidity'], 2);
        $ammonia = number_format($data['amonia'], 2);
        $kelas = $this->getKelas($suhu,$kelembaban,$ammonia);
        $date = $this->getData();
        $dateTime = $date['lt'];
        $dateNow = date("Y-m-d H:i:s");
            DB::table('monitorings')->insert([
                'suhu' => $suhu,
                'kelembaban' => $kelembaban,
                'ammonia' => $ammonia,
                'kelas' => $kelas,
                'updated_at' => $dateNow,
                'created_at' => $dateTime

            ]);

        \Log::info("Cron is working fine!");
    }
}
