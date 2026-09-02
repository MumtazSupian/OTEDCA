<?php

namespace App\Http\Controllers\Asuransi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Asuransi\MasterAsuransi;

class DataAsuransiController extends Controller
{
    public function index(Request $request)
    {
        // Default periode filter (Bulan ini)
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        
        $statusAsuransi = $request->input('status_asuransi', 'Semua');
        $jenis = $request->input('jenis', 'Semua');
        $pembiayaan = $request->input('pembiayaan', 'Semua');
        $perusahaan = $request->input('perusahaan', 'Semua');
        $search = $request->input('search', '');

        // List Perusahaan Asuransi dari Master Asuransi
        $rawPerusahaan = MasterAsuransi::getDefaultPerusahaan();
        $perusahaanList = array_merge(['Semua'], array_column($rawPerusahaan, 'nama_perusahaan'));

        // Data list (kosong untuk sementara sesuai request)
        $kendaraanList = [];
        $totalKendaraan = 0;
        $totalTerfilter = 0;

        return view('Asuransi.data_asuransi', compact(
            'startDate',
            'endDate',
            'statusAsuransi',
            'jenis',
            'pembiayaan',
            'perusahaan',
            'search',
            'perusahaanList',
            'kendaraanList',
            'totalKendaraan',
            'totalTerfilter'
        ));
    }
}
