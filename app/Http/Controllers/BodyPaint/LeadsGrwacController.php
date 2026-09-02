<?php

namespace App\Http\Controllers\BodyPaint;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LeadsGrwacController extends Controller
{
    public function dashboard(Request $request = null)
    {
        $request = $request ?? request();
        $tahun = $request->input('tahun', date('Y'));
        $bulan = $request->input('bulan', 'Agu');

        // Summary KPI Stats (0 untuk sementara)
        $kpi = [
            'total_prospect' => 0,
            'unit_entry' => 0,
            'conv_rate' => '0.0%',
            'avg_lead_time' => 0,
            'gap' => 0,
            'target_leads' => 0,
            'overdue' => 0,
        ];

        // Funnel Status Data
        $funnelData = [
            'baru' => 0,
            'dihubungi' => 0,
            'janji' => 0,
        ];

        // Status Asuransi Data
        $asuransiData = [
            'berasuransi' => 0,
            'tidak_berasuransi' => 0,
        ];

        // Leads vs Target 12 Bulan
        $chart12Bulan = [
            'labels' => ['Sep 25', 'Okt 25', 'Nov 25', 'Des 25', 'Jan 26', 'Feb 26', 'Mar 26', 'Apr 26', 'Mei 26', 'Jun 26', 'Jul 26', 'Agu 26'],
            'leads' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            'target' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        ];

        // Top SA GR - Input Terbanyak (kosong)
        $topSaGr = [];

        // Top SA BP - Konversi Tertinggi (kosong)
        $topSaBp = [];

        // Daftar Overdue (kosong)
        $daftarOverdue = [];

        return view('BodyPaint.leads_grwac.dashboard', compact(
            'tahun',
            'bulan',
            'kpi',
            'funnelData',
            'asuransiData',
            'chart12Bulan',
            'topSaGr',
            'topSaBp',
            'daftarOverdue'
        ));
    }

    public function inputProspect()
    {
        $modelKendaraanList = [
            'Agya', 'Avanza', 'Calya', 'Corolla Cross', 'Fortuner', 
            'Hilux', 'Innova Reborn', 'Innova Zenix', 'Raize', 'Rush', 
            'Veloz', 'Vios', 'Voxy', 'Yaris', 'Yaris Cross', 'Lainnya'
        ];

        return view('BodyPaint.leads_grwac.input_prospect', compact('modelKendaraanList'));
    }

    public function daftarProspect(Request $request = null)
    {
        $request = $request ?? request();
        $search = $request->input('q', '');
        $status = $request->input('status', 'Semua');

        $statusList = [
            'Semua',
            'Baru',
            'Dihubungi',
            'Janji',
            'Unit Entry',
            'Ditolak',
            'Hilang',
        ];

        // Data Prospect BP (kosong untuk sementara sesuai request)
        $prospectList = [];
        $totalProspect = 0;

        return view('BodyPaint.leads_grwac.daftar_prospect', compact(
            'search',
            'status',
            'statusList',
            'prospectList',
            'totalProspect'
        ));
    }

    public function prospekSaya(Request $request = null)
    {
        $request = $request ?? request();

        // 4 KPI Summary Cards (0 untuk sementara)
        $kpi = [
            'total_input' => 0,
            'unit_entry' => 0,
            'target_leads' => 0,
            'gap' => 0,
        ];

        // Data Prospek Saya (kosong untuk sementara sesuai request)
        $prospekList = [];
        $totalProspectAktif = 0;

        return view('BodyPaint.leads_grwac.prospek_saya', compact(
            'kpi',
            'prospekList',
            'totalProspectAktif'
        ));
    }
}
