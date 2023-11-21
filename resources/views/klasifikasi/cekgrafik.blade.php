<?php  


// //suhu
// $url = "https://backend.thinger.io/v3/users/KelasKilat/devices/KandangAyam_Bantuas/resources/temp";
// $headers = [
//     "Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHAiOjE2OTI1NjYxNDMsImlhdCI6MTY5MjU1ODk0Mywicm9sZSI6InVzZXIiLCJ1c3IiOiJLZWxhc0tpbGF0In0.NKkRF0Mdh73xbPH4XIAz70qKjduNeDJgzRgtTXSNyFI"
// ];

// $ch = curl_init($url);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// $response = curl_exec($ch);
// curl_close($ch);

// $suhuValue = json_decode($response, true);

// $suhu = number_format($suhuValue, 2);

// //kelembaban
// $url = "https://backend.thinger.io/v3/users/KelasKilat/devices/KandangAyam_Bantuas/resources/hum";
// $headers = [
//     "Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHAiOjE2OTI1NjYxNDMsImlhdCI6MTY5MjU1ODk0Mywicm9sZSI6InVzZXIiLCJ1c3IiOiJLZWxhc0tpbGF0In0.NKkRF0Mdh73xbPH4XIAz70qKjduNeDJgzRgtTXSNyFI"
// ];

// $ch = curl_init($url);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// $response = curl_exec($ch);
// curl_close($ch);

// $kelembabanValue = json_decode($response, true);

// $kelembaban = number_format($kelembabanValue, 2);

// //ammonia
// $url = "https://backend.thinger.io/v3/users/KelasKilat/devices/KandangAyam_Bantuas/resources/NH3";
// $headers = [
//     "Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHAiOjE2OTI1NjYxNDMsImlhdCI6MTY5MjU1ODk0Mywicm9sZSI6InVzZXIiLCJ1c3IiOiJLZWxhc0tpbGF0In0.NKkRF0Mdh73xbPH4XIAz70qKjduNeDJgzRgtTXSNyFI"
// ];

// $ch = curl_init($url);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// $response = curl_exec($ch);
// curl_close($ch);

// $ammoniaValue = json_decode($response, true);

// $ammonia = number_format($ammoniaValue, 2);



// Contoh data Anda (gantilah dengan data Anda sendiri)
// $data = array(
//     'suhu' => array(25, 30, 35, 28, 32),
//     'kelembaban' => array(60, 55, 40, 75, 50),
//     'ammonia' => array(0.1, 0.05, 0.2, 0.08, 0.15),
//     'kelas' => array('A', 'B', 'C', 'A', 'B')
// );

// // Fungsi untuk melakukan normalisasi Min-Max
// function min_max_normalization($data) {
//     $min = min($data);
//     $max = max($data);

//     $normalized_data = array();
//     foreach ($data as $value) {
//         $normalized_value = ($value - $min) / ($max - $min);
//         $normalized_data[] = $normalized_value;
//     }

//     return $normalized_data;
// }

// // Normalisasi Min-Max untuk kolom suhu, kelembaban, dan ammonia
// $suhu_normalized = min_max_normalization($data['suhu']);
// $kelembaban_normalized = min_max_normalization($data['kelembaban']);
// $ammonia_normalized = min_max_normalization($data['ammonia']);
// $kelas_normalized = min_max_normalization($data['kelas']);

// // Hasil normalisasi
// echo "Suhu Normalized: " . implode(', ', $suhu_normalized) . "\n";
// echo "Kelembaban Normalized: " . implode(', ', $kelembaban_normalized) . "\n";
// echo "Ammonia Normalized: " . implode(', ', $ammonia_normalized) . "\n";
// echo "kelas Normalized: " . implode(', ', $kelas_normalized) . "\n";

// Data kelas tidak perlu dinormalisasi karena itu adalah data kategorikal.




// $dataUji= [$suhu,$kelembaban,$ammonia];


// function euclideanDistance($data1, $data2)
// {
//     $sum = 0;
//     for ($i = 0; $i < count($data1); $i++) {
//         $sum += pow(($data1[$i] - $data2[$i]), 2);
//     }
//     return sqrt($sum);
// }

// // Fungsi untuk menghitung kelas terbanyak dari tetangga terdekat
// function getMostFrequentClass($classes)
// {
//     $classCounts = array_count_values($classes);
//     arsort($classCounts);
//     return array_keys($classCounts)[0];
// }

// // Data uji
// $testData = array( $dataUji );
    

// // K value
// $k = 3;


//     // Membaca data training dari hasil query
//     $trainingData = $dataTraining;
    
//     // Hitung jarak antara data uji dan data training
//     $distances = array();
//     foreach ($trainingData as $train) {
//         $dist = euclideanDistance(array_slice($train, 0, -1), end($testData));
//         $distances[] = array($train, $dist);
//     }

//     // Urutkan jarak dari yang terkecil
//     usort($distances, function ($a, $b) {
//         return $a[1] <=> $b[1];
//     });

//     // Ambil k tetangga terdekat
//     $neighbors = array_slice($distances, 0, $k);

//     // Ambil kelas dari tetangga terdekat
//     $neighborClasses = array();
//     foreach ($neighbors as $neighbor) {
//         $neighborClasses[] = $neighbor[0][3];
//     }

//     // Prediksi kelas data uji berdasarkan kelas terbanyak dari tetangga terdekat
//     $predictedClass = getMostFrequentClass($neighborClasses);
//     echo $predictedClass;

?>
<!DOCTYPE html>
<html>
<head>
    <title>Hasil Klasifikasi KNN</title>
</head>
<body>
    <h1>Hasil Klasifikasi KNN</h1>

    <form method="POST" action="{{ route('testing') }}">
        @csrf
        <label for="suhu">Suhu:</label>
        <input type="number" name="suhu" required>

        <label for="kelembaban">Kelembaban:</label>
        <input type="number" name="kelembaban" required>

        <label for="kelembaban">Ammonia:</label>
        <input type="number" name="ammonia" required>

        <label for="kelembaban">k:</label>
        <input type="number" name="k" required>

        <button type="submit">Prediksi</button>
    </form>

    @if(isset($kelas_prediksi))
    <p>Hasil Prediksi: {{ $kelas_prediksi }}</p></br>
    <p>Hasil K: {{ $k }}</p></br>

    
    <p>Hasil suhu: {{ $suhu }}</p></br>
    <p>Hasil kelembaban: {{ $kelembaban }}</p></br>
    <p>Hasil ammonia: {{ $ammonia }}</p></br>
               
    @endif
</body>
</html>


   