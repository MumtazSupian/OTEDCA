<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VehicleLookupController extends Controller
{
    public function index(Request $request)
    {
        $mode = $request->get('mode', 'konsumen'); // 'konsumen' or 'kendaraan'
        $keyword = $request->get('q', '');

        $sampleResults = [];
        $selectedDetail = null;

        return view('Customer.vehicle_lookup', compact('mode', 'keyword', 'sampleResults', 'selectedDetail'));
    }
}
