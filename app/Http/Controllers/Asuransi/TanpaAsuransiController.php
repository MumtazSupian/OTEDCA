<?php

namespace App\Http\Controllers\Asuransi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Asuransi\MasterAsuransi;

class TanpaAsuransiController extends Controller
{
    public function index(Request $request)
    {
        // Default periode filter (Bulan ini)
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        
        $pembiayaan = $request->input('pembiayaan', 'Semua');
        $search = $request->input('search', '');

        // List Perusahaan Asuransi dari Master Asuransi
        $rawPerusahaan = MasterAsuransi::getDefaultPerusahaan();
        $perusahaanList = array_column($rawPerusahaan, 'nama_perusahaan');

        // Data list (kosong untuk sementara sesuai request)
        $kendaraanList = [];
        $totalKendaraan = 0;

        return view('Asuransi.tanpa_asuransi', compact(
            'startDate',
            'endDate',
            'pembiayaan',
            'search',
            'perusahaanList',
            'kendaraanList',
            'totalKendaraan'
        ));
    }
}
