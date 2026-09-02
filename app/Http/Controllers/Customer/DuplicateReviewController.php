<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DuplicateReviewController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'Pending');
        $confidence = $request->get('confidence', 'Semua');
        $sumberData = $request->get('sumber_data', 'Semua Sumber');

        // Sample pair with '-' placeholder values as requested
        $samplePairs = [
            [
                'id' => 1,
                'rule_code' => 'R5b',
                'match_type' => 'Nama+Alamat',
                'score' => 75,
                'confidence_level' => 'Medium',
                'status' => 'Pending',
                'data_left' => [
                    'nama' => '-',
                    'tipe' => '-',
                    'sumber' => '-',
                    'nik' => '-',
                    'gender' => '-',
                    'tgl_lahir' => '-',
                    'hp' => '-',
                    'email' => '-',
                    'alamat' => '-',
                    'kendaraan' => '-',
                    'transaksi' => '-',
                    'service' => '-',
                    'diperbarui' => '-',
                    'kelengkapan' => '-/100',
                ],
                'data_right' => [
                    'nama' => '-',
                    'tipe' => '-',
                    'sumber' => '-',
                    'nik' => '-',
                    'gender' => '-',
                    'tgl_lahir' => '-',
                    'hp' => '-',
                    'email' => '-',
                    'alamat' => '-',
                    'kendaraan' => '-',
                    'transaksi' => '-',
                    'service' => '-',
                    'diperbarui' => '-',
                    'kelengkapan' => '-/100',
                ],
            ]
        ];

        return view('Customer.duplicate_review', compact('status', 'confidence', 'sumberData', 'samplePairs'));
    }
}
