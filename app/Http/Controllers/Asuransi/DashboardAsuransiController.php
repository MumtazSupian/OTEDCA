<?php

namespace App\Http\Controllers\Asuransi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardAsuransiController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->input('periode', '');

        // 1. 6 KPI Top Summary Cards (0 untuk sementara)
        $kpi = [
            'total_kendaraan' => 0,
            'aktif' => 0,
            'segera_habis' => 0,
            'kritis' => 0,
            'expired' => 0,
            'tanpa_data' => 0,
            'leasing' => 0,
            'cash' => 0,
        ];

        // 2. Kelengkapan Data Asuransi
        $kelengkapan = [
            'sudah_terisi' => 0,
            'belum_terisi' => 0,
        ];

        // 3. Status Follow-Up Asuransi
        $statusFu = [
            'open' => 0,
            'overdue' => 0,
            'berhasil' => 0,
        ];

        // 4. Jenis Asuransi Aktif (Donut)
        $jenisAsuransi = [
            'comp' => 0,
            'tlo' => 0,
        ];

        // 5. Top Perusahaan Asuransi (Horizontal Bar)
        $topPerusahaan = [
            'labels' => ['AAB', 'RAMAYANA', 'ACA', 'SOMPO', 'MAG', 'SINARMAS', 'BCAI', 'ZURICH'],
            'data' => [0, 0, 0, 0, 0, 0, 0, 0],
        ];

        // 6. Expiry 12 Bulan ke Depan (Bar)
        $expiry12Bulan = [
            'labels' => ['2026-08', '2026-09', '2026-10', '2026-11', '2026-12', '2027-01', '2027-02', '2027-03', '2027-04', '2027-05', '2027-06', '2027-07'],
            'data' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        ];

        // 7. Aging Kendaraan Tanpa Asuransi (Horizontal Bar)
        $agingTanpaAsuransi = [
            'labels' => ['>12 bln', '6–12 bln', '3–6 bln', '0–3 bln'],
            'data' => [0, 0, 0, 0],
        ];

        // 8. Tren Registrasi Asuransi 12 Bulan (Line)
        $trenRegistrasi = [
            'labels' => ['2025-09', '2025-10', '2025-11', '2025-12', '2026-01', '2026-02', '2026-03', '2026-04', '2026-05', '2026-06', '2026-07', '2026-08'],
            'data' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        ];

        // 9. Konversi Follow-Up Box
        $konversiFu = [
            'total_task' => 0,
            'open' => 0,
            'berhasil' => 0,
            'tidak_berlanjut' => 0,
            'rate' => '0.0%',
        ];

        // 10. Top Model Tanpa Asuransi (Horizontal Bar)
        $topModelTanpaAsuransi = [
            'labels' => ['AVANZA', 'CALYA', 'RUSH', 'AGYA', 'RAIZE', 'INNOVA', 'Innova Zenix Hybrid', 'FORTUNER 4X2', 'ALPHARD', 'HILUX D-CAB'],
            'data' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        ];

        // 11. Coverage Asuransi per Sales (Stacked Horizontal Bar)
        $coverageSales = [
            'labels' => ['SILVYANA AFVINNY', 'MOCH ERSYAD', 'UJANG SOLAH', 'JULIZAR SETIAWAN', 'GALIH PRAMANA', 'KIKI RAPI', 'DEDEN SUNANDAR', 'YOGGY NURJAYA', 'DEDI SOPIYAN', 'DADANG DAENURI'],
            'sudah' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            'belum' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        ];

        // 12. 10 Asuransi Terdekat Habis (kosong untuk sementara)
        $terdekatHabisList = [];

        return view('Asuransi.dashboard_asuransi', compact(
            'periode',
            'kpi',
            'kelengkapan',
            'statusFu',
            'jenisAsuransi',
            'topPerusahaan',
            'expiry12Bulan',
            'agingTanpaAsuransi',
            'trenRegistrasi',
            'konversiFu',
            'topModelTanpaAsuransi',
            'coverageSales',
            'terdekatHabisList'
        ));
    }
}
