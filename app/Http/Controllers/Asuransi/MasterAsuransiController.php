<?php

namespace App\Http\Controllers\Asuransi;

use App\Http\Controllers\Controller;
use App\Models\Asuransi\MasterAsuransi;
use Illuminate\Http\Request;

class MasterAsuransiController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->input('tab', 'perusahaan');

        // 1. Data Perusahaan Asuransi
        $perusahaanList = MasterAsuransi::getDefaultPerusahaan();

        // 2. Data Pengaturan / Settings Default
        $settings = [
            'kritis_hari' => 30,
            'peringatan_hari' => 60,
            'scope_tahun' => 5,
            'lookback_bulan' => 12,
            'habis_bulan' => 2,
            'snooze_bulan' => 6,
            'waktu_sync' => '02:00',
            'aktifkan_wa' => false,
        ];

        // 3. Data Riwayat Import (kosong untuk sementara)
        $riwayatImport = [];

        return view('Asuransi.master_asuransi', compact(
            'activeTab',
            'perusahaanList',
            'settings',
            'riwayatImport'
        ));
    }
}
