<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerListController extends Controller
{
    public function index(Request $request)
    {
        $metrics = [
            'konsumen_unik'      => 0,
            'duplikat_tergabung' => 0,
            'hanya_penjualan'    => 0,
            'hanya_service'      => 0,
            'penjualan_service'  => 0,
            'hanya_database'     => 0,
            'total_kendaraan'    => 0,
        ];

        $customers = [];

        return view('Customer.customer_list', compact('metrics', 'customers'));
    }
}
