<?php
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
function klasifikasi($dataUji, $k, $dataTraining){
            

        // Data uji
        $testData = array( $dataUji );
            

        // K value
        


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
?>