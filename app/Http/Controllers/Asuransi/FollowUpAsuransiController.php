<?php

namespace App\Http\Controllers\Asuransi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FollowUpAsuransiController extends Controller
{
    public function index(Request $request)
    {
        $sales = $request->input('sales', 'Semua Sales');
        $status = $request->input('status', 'Semua Status');
        $tipe = $request->input('tipe', 'Semua Tipe');
        $overdue = $request->boolean('overdue');
        $search = $request->input('q', '');

        // List Status Follow-up
        $statusList = [
            'Semua Status',
            'UNASSIGNED',
            'OPEN',
            'In Progress',
            'Janji Temu',
            'Ditunda',
            'Tidak Bisa Dihubungi',
            'Berhasil Terdaftar',
            'Berhasil (Luar)',
            'Tidak Berminat',
            'Data Salah',
            'Pindah Tangan',
        ];

        // List Tipe
        $tipeList = [
            'Semua Tipe',
            'Tanpa Asuransi',
            'Mau Habis',
        ];

        // List Sales (bisa ditambahkan dari User/Sales nanti)
        $salesList = [
            'Semua Sales',
        ];

        // Data Task Follow-Up (kosong untuk sementara sesuai request)
        $taskList = [];
        $totalTask = 0;

        return view('Asuransi.follow_up_asuransi', compact(
            'sales',
            'status',
            'tipe',
            'overdue',
            'search',
            'statusList',
            'tipeList',
            'salesList',
            'taskList',
            'totalTask'
        ));
    }
}
