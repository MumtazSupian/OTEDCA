<?php

namespace App\Http\Controllers\Asuransi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MonitoringFollowUpController extends Controller
{
    public function index(Request $request)
    {
        // Data list per SPV (kosong untuk sementara sesuai request)
        $spvList = [];

        return view('Asuransi.monitoring_follow_up', compact('spvList'));
    }
}
