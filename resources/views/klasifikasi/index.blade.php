@extends('layouts.user')

@section('title', 'Data')

@section('breadcrumbs')
<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Klasifikasi KNN</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="{{ url('home') }}">Home</a></li>
                            <li class="active">Klasifikasi KNN</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('content')




<!-- <div class="content mt-3">
<div class="animated fadeIn" >
              
              @if ($kelas == 'Ideal')
              <div class="alert alert-success">
              <span class="badge badge-pill badge-success"></span>
              Kandang Dalam Kondisi Yang Ideal
              </div>
              @elseif($kelas == "Baik")
              <div class="alert alert-primary">
              <span class="badge badge-pill badge-primary"><?= $kelas?></span>
              Kandang Dalam Kondisi Baik
              </div>
              @elseif($kelas == "Buruk")
              <div class="alert alert-warning">
              <span class="badge badge-pill badge-warning"><?= $kelas?></span>
              Kandang Dalam Kondisi Yang Buruk
              </div>
              @elseif($kelas == "Berbahaya")
              <div class="alert alert-danger">
              <span class="badge badge-pill badge-danger"><?= $kelas?></span>
              Kandang Dalam Kondisi Dalam Bahaya, Segera Pergi Ke Kandang
              </div>
              @endif
</div>
</div> -->



@endsection

@push('js')

<div class="animated fadeIn">
    <span id="cekgrafik"></span> 
</div>
<div class="col-lg-3 col-md-6 ">
    <div class="social-box linkedin">
        <i> <img class="align-content " src="{{ asset('style/images/suhu.png') }}" style="width: 100px;"></i>
        <ul>
            <li>
                <span>SUHU</span>
            </li>
            <li>
                <strong><span id="ceksuhu" style="font-size: 25px; font-weight: bold;">0</span> Celcius</strong>
            </li>
        </ul>
    </div>
</div><!--/.col-->
<div class="col-lg-3 col-md-6">
    <div class="social-box twitter">
        <i > <img class="align-content" src="{{ asset('style/images/kelembaban.png') }}" style="width: 70px;"></i>
        <ul>
            <li>
                <span>KELEMBABAN</span>
            </li>
            <li>
                <strong><span id="cekkelembaban" style="font-size: 25px; font-weight: bold;">0</span> %</strong>
            </li>
        </ul>
    </div>
</div><!--/.col-->
<div class="col-lg-3 col-md-6">
    <div class="social-box google-plus">
        <i> <img class="align-content" src="{{ asset('style/images/ammonia.png') }}" style="width: 80px;"></i>
        <ul>
            <li>
                <span>AMMONIA</span>
            </li>
            <li>
                <strong><span id="cekammonia" style="font-size: 25px; font-weight: bold;">0</span> ppm</strong>
            </li>
        </ul>
    </div>
</div><!--/.col-->
<div class="col-lg-3 col-md-6">
    <div class="social-box facebook">
        <i> <img class="align-content" src="{{ asset('style/images/status.png') }}" style="width: 100px;"></i>
        <ul>
            <li>
                <span>STATUS</span>
            </li>
            <li>
                <strong><span id="cekkelas" style="font-size: 25px; font-weight: bold;">-</span></strong>
            </li>
        </ul>
    </div>
</div><!--/.col-->

<div class="col-lg">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="card">
    <div class="card-body d-flex flex-column align-items-center">
        <h4 class="mb-3">Monitoring Kandang</h4>
        <div style="width: 100%; max-width: 800px; text-align: center;">
            <canvas id="myChart" ></canvas>
        </div>
    </div>
</div>
</div>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script> -->
    <script>
        var ctx = document.getElementById("myChart");
        var nilai_amonia = document.getElementById("nilai_suhu");
        var nilai_metana = document.getElementById("nilai_kelembaban");
        var nilai_kondisi = document.getElementById("nilai_ammonia");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [ {
                    label: 'Ammonia',
                    data: [],
                    borderColor: '#FF0000',
                    backgroundColor: '#FFC0CB',
                    borderWidth: 2,
                },{
                    label: 'Suhu',
                    data: [],
                    borderColor: '#36A2EB',
                    backgroundColor: '#9BD0F5',
                    borderWidth: 2,

                }, {
                    label: 'Kelembaban',
                    data: [],
                    borderColor: '#FF6384',
                    backgroundColor: '#eb8628',
                    borderWidth: 2,
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        var updateChart = function() {
            $.ajax({
                url: "{{ route('cekGrafik') }}",
                type: 'GET',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    // update data chart
                    console.log(data)
                    data.labels = data.labels.reverse();
                    data.ammonia = data.ammonia.reverse();
                    data.suhu = data.suhu.reverse();
                    data.kelembaban = data.kelembaban.reverse();
                    myChart.data.labels = data.labels;
                    myChart.data.datasets[0].data = data.ammonia;
                    myChart.data.datasets[1].data = data.suhu;
                    myChart.data.datasets[2].data = data.kelembaban;
                    
                    myChart.update();
                    // update data dibawah chart
                    nilai_suhu.innerHTML = data.nilai_last_suhu;
                    nilai_kelembaban.innerHTML = data.nilai_last_kelembaban;
                    nilai_ammonia.innerHTML = data.nilai_last_ammonia;
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        updateChart();
        setInterval(() => {
            updateChart();
        }, 1000);
    </script>

    <script type="text/javascript">
        var routeURLSuhu = "{{ route('cekSuhu') }}";
        var routeURLKelembaban = "{{ route('cekKelembaban') }}";
        var routeURLAmmonia = "{{ route('cekAmmonia') }}";
        var routeURLKelas = "{{ route('cekKelas') }}";
        $(document).ready(function(){
            setInterval(function(){
                $("#ceksuhu").load(routeURLSuhu);
                $("#cekkelembaban").load(routeURLKelembaban);
                $("#cekammonia").load(routeURLAmmonia);
                $("#cekkelas").load(routeURLKelas);
            }, 1000);
        });
    </script>





<!-- 

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('myChart').getContext('2d');

        // Data yang ingin Anda gunakan
        const labels = {!! json_encode(array_reverse($label)) !!};
        const suhuData = {!! json_encode(array_reverse($suhu)) !!};
        const kelembabanData = {!! json_encode(array_reverse($kelembaban)) !!};
        const ammoniaData = {!! json_encode(array_reverse($ammonia)) !!};

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Suhu',
                    data: suhuData,
                    borderWidth: 1
                }, {
                    label: 'Kelembaban',
                    data: kelembabanData,
                    borderWidth: 1
                }, {
                    label: 'Ammonia',
                    data: ammoniaData,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script> -->
 
    
@endpush