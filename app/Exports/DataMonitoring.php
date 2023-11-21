<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Monitoring;

class DataMonitoring implements FromCollection
{
    protected $cariTanggal;

    public function __construct($cariTanggal)
    {
        $this->cariTanggal = $cariTanggal;
    }

    public function collection()
    {
        // Ambil data dari tabel "monitorings" berdasarkan kriteria pencarian
        return Monitoring::whereDate('created_at', '=', $this->cariTanggal)->get();
    }
}
