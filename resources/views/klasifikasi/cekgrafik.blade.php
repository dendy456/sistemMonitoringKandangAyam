<?php  


//suhu
$url = "https://backend.thinger.io/v3/users/KelasKilat/devices/KandangAyam_Bantuas/resources/temp";
$headers = [
    "Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHAiOjE2OTI1NjYxNDMsImlhdCI6MTY5MjU1ODk0Mywicm9sZSI6InVzZXIiLCJ1c3IiOiJLZWxhc0tpbGF0In0.NKkRF0Mdh73xbPH4XIAz70qKjduNeDJgzRgtTXSNyFI"
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);
curl_close($ch);

$suhuValue = json_decode($response, true);

$suhu = number_format($suhuValue, 2);

//kelembaban
$url = "https://backend.thinger.io/v3/users/KelasKilat/devices/KandangAyam_Bantuas/resources/hum";
$headers = [
    "Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHAiOjE2OTI1NjYxNDMsImlhdCI6MTY5MjU1ODk0Mywicm9sZSI6InVzZXIiLCJ1c3IiOiJLZWxhc0tpbGF0In0.NKkRF0Mdh73xbPH4XIAz70qKjduNeDJgzRgtTXSNyFI"
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);
curl_close($ch);

$kelembabanValue = json_decode($response, true);

$kelembaban = number_format($kelembabanValue, 2);

//ammonia
$url = "https://backend.thinger.io/v3/users/KelasKilat/devices/KandangAyam_Bantuas/resources/NH3";
$headers = [
    "Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHAiOjE2OTI1NjYxNDMsImlhdCI6MTY5MjU1ODk0Mywicm9sZSI6InVzZXIiLCJ1c3IiOiJLZWxhc0tpbGF0In0.NKkRF0Mdh73xbPH4XIAz70qKjduNeDJgzRgtTXSNyFI"
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);
curl_close($ch);

$ammoniaValue = json_decode($response, true);

$ammonia = number_format($ammoniaValue, 2);




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
    echo $predictedClass;

?>
<div class="animated fadeIn">
              
                @if ($predictedClass == 'Ideal')
                <div class="alert alert-success">
                <span class="badge badge-pill badge-success"><?= $predictedClass?></span>
                Kandang Dalam Kondisi Yang Ideal
                </div>
                @elseif($predictedClass == "Baik")
                <div class="alert alert-primary">
                <span class="badge badge-pill badge-primary"><?= $predictedClass?></span>
                Kandang Dalam Kondisi Baik
                </div>
                @elseif($predictedClass == "Buruk")
                <div class="alert alert-warning">
                <span class="badge badge-pill badge-warning"><?= $predictedClass?></span>
                Kandang Dalam Kondisi Yang Buruk
                </div>
                @elseif($predictedClass == "Berbahaya")
                <div class="alert alert-danger">
                <span class="badge badge-pill badge-danger"><?= $predictedClass?></span>
                Kandang Dalam Kondisi Dalam Bahaya, Segera Pergi Ke Kandang
                </div>
                @endif
</div>

   