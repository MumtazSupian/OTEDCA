<?php

namespace App\Http\Controllers\BodyPaint;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MasterBpController extends Controller
{
    public function index(Request $request = null)
    {
        $request = $request ?? request();
        $activeTab = $request->input('tab', 'sla');
        $tahun = $request->input('tahun', date('Y'));

        // 1. Pengaturan SLA
        $slaSettings = [
            'batas_kontak_pertama' => 3,
            'interval_fu' => 7,
            'outlet_id_bp' => '',
            'batas_fu_asuransi' => 60,
        ];

        // 2. Target CPUS per Bulan
        $months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        $targetCpus = [];
        foreach ($months as $m) {
            $targetCpus[$m] = 0;
        }

        // 3. Rotasi SA BP (kosong untuk sementara sesuai request)
        $rotasiSaList = [];
        $availableSaList = [
            'Pilih SA BP untuk ditambahkan',
        ];

        return view('BodyPaint.master', compact(
            'activeTab',
            'tahun',
            'slaSettings',
            'months',
            'targetCpus',
            'rotasiSaList',
            'availableSaList'
        ));
    }
}
