<?php

namespace App\Http\Controllers\BodyPaint;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MonitoringAsuransiBpController extends Controller
{
    public function dashboard(Request $request = null)
    {
        $request = $request ?? request();

        // 7 KPI Stat Cards (0 untuk sementara)
        $kpi = [
            'total_comp_aktif' => 0,
            'habis_30_hari' => 0,
            'mau_habis_60_hari' => 0,
            'sudah_dihubungi' => 0,
            'belum_dihubungi' => 0,
            'sudah_diklaim' => 0,
            'walkin_booking' => 0,
        ];

        // Chart 1: Alasan Konsumen (Verbatim)
        $alasanVerbatim = [
            'labels' => ['Lainnya', 'Sudah walk-in ke DCM', 'Belum ada waktu'],
            'data' => [0, 0, 0],
        ];

        // Chart 2: Urgency Expiry
        $urgencyExpiry = [
            'kritis_30' => 0,
            'peringatan_60' => 0,
            'aman_gt_60' => 0,
            'total_kendaraan' => 0,
        ];

        // 10 Kendaraan Paling Dekat Expiry - Belum Dihubungi (kosong untuk sementara)
        $dekatExpiryList = [];

        return view('BodyPaint.monitoring_asuransi.dashboard', compact(
            'kpi',
            'alasanVerbatim',
            'urgencyExpiry',
            'dekatExpiryList'
        ));
    }

    public function followUp(Request $request = null)
    {
        $request = $request ?? request();
        $sisaHari = $request->input('sisa_hari', 'Semua aktif');
        $statusFu = $request->input('status_fu', 'Semua');
        $perusahaan = $request->input('perusahaan', 'Semua');
        $verbatim = $request->input('verbatim', 'Semua');
        $search = $request->input('q', '');

        // 1. Pilihan Sisa Hari (Sesuai Foto 1)
        $sisaHariList = [
            'Semua aktif',
            '≤ 30 hari',
            '≤ 60 hari',
            '≤ 90 hari',
        ];

        // 2. Pilihan Status Follow-up (Sesuai Foto 2)
        $statusFuList = [
            'Semua',
            'Belum Dihubungi',
            'Sudah Dihubungi',
        ];

        // 3. Pilihan Perusahaan diambil dari Master Asuransi
        try {
            $masterCompanies = \App\Models\Asuransi\MasterAsuransi::where('status', 'aktif')
                ->orderBy('urutan', 'asc')
                ->pluck('nama_perusahaan')
                ->toArray();

            if (empty($masterCompanies)) {
                $masterCompanies = \App\Models\Asuransi\MasterAsuransi::pluck('nama_perusahaan')->toArray();
            }
        } catch (\Exception $e) {
            $masterCompanies = [];
        }

        $perusahaanList = array_merge(['Semua'], $masterCompanies);

        // 4. Pilihan Verbatim Terakhir (Sesuai Foto 3, 4, 5)
        $verbatimList = [
            'Semua',
            'Sudah booking perbaikan di DCM',
            'Sudah walk-in ke DCM',
            'Belum ada waktu',
            'Masih di luar kota',
            'Tidak diangkat / tidak bisa dihubungi',
            'Nomor tidak aktif / salah nomor',
            'Minta dihubungi lagi',
            'Sudah klaim sendiri',
            'Sedang dalam proses klaim',
            'Sudah ke bengkel lain',
            'Tidak berminat perbaikan di sini',
            'Asuransi ditanggung perusahaan / leasing',
            'Asuransi sudah tidak aktif / tidak diperpanjang',
            'Limit klaim sudah habis',
            'Kerusakan tidak di-cover asuransi',
            'Kendaraan kondisi masih bagus',
            'Kendaraan sudah dijual',
            'Terkendala biaya / excess tinggi',
            'Lainnya',
        ];

        // Data List Monitoring & Follow-Up (kosong untuk sementara sesuai request)
        $monitoringList = [];

        return view('BodyPaint.monitoring_asuransi.monitoring_follow_up', compact(
            'sisaHari',
            'statusFu',
            'perusahaan',
            'verbatim',
            'search',
            'sisaHariList',
            'statusFuList',
            'perusahaanList',
            'verbatimList',
            'monitoringList'
        ));
    }
}
