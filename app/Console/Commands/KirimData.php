<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\Monitoring;
use App\Models\DataTraining;


class KirimData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'KirimData';

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
    private function getData($url)
    {
        $headers = [
            "Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJkZXYiOiJLYW5kYW5nQXlhbV9CYW50dWFzIiwiaWF0IjoxNjkyNjgxNTQ5LCJqdGkiOiI2NGU0NDU0ZGE2YTIyNWY3ODAwNzI1YzMiLCJzdnIiOiJhcC1zb3V0aGVhc3QuYXdzLnRoaW5nZXIuaW8iLCJ1c3IiOiJLZWxhc0tpbGF0In0.weXlqGTTwe2PfSYKK-0OBLhQodAmBB9sLiCG1aTvTJc"
        ];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        curl_close($ch);

        $dataValue = json_decode($response, true);

        $data = number_format($dataValue, 2);
        return $data;
    }

    private function getKelas($suhu,$kelembaban,$ammonia)
    {
        $datatraining = DataTraining::all();
        
        $dataUji= [];
        $dataTraining= [];
        foreach($datatraining as $dt){
            $Training=[$dt->suhu,$dt->kelembaban,$dt->ammonia,$dt->kelas];
            $dataTraining[]=$Training;
        }

        $dataUji= [$suhu,$kelembaban,$ammonia];
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
        //suhu
        $suhu = $this->getData("https://backend.thinger.io/v3/users/KelasKilat/devices/KandangAyam_Bantuas/resources/temp");
        //kelembaban
        $kelembaban = $this->getData("https://backend.thinger.io/v3/users/KelasKilat/devices/KandangAyam_Bantuas/resources/hum");
        //ammonia
        $ammonia = $this->getData("https://backend.thinger.io/v3/users/KelasKilat/devices/KandangAyam_Bantuas/resources/CH4");
        //kelas
        $kelas = $this->getKelas($suhu,$kelembaban,$ammonia);
        //tanggal
        $dateTime = date("Y-m-d H:i:s");
            DB::table('monitorings')->insert([
                'suhu' => $suhu,
                'kelembaban' => $kelembaban,
                'ammonia' => $ammonia,
                'kelas' => $kelas,
                'created_at' => $dateTime
            ]);
        

        return $suhu;
    }
}
