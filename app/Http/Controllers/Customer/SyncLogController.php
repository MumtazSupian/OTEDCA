<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SyncLogController extends Controller
{
    public function index(Request $request)
    {
        $metrics = [
            'total_customer'   => 0,
            'sudah_verified'   => 0,
            'duplikat_pending' => 0,
            'sync_terakhir'    => '-',
            'status_terakhir'  => 'completed',
        ];

        $syncSchedule = [
            'type'       => 'Sync Otomatis (Incremental)',
            'schedule'   => 'Setiap hari pukul 02:00 WIB',
            'next_run'   => '21 jam dari sekarang',
            'last_run'   => '-',
        ];

        // Empty sync logs for initial UI
        $syncLogs = [];

        return view('Customer.sync_log', compact('metrics', 'syncSchedule', 'syncLogs'));
    }
}
