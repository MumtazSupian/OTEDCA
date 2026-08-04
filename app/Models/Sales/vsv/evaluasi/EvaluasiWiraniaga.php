<?php

namespace App\Models\Sales\vsv\evaluasi;

use Illuminate\Database\Eloquent\Model;

class EvaluasiWiraniaga extends Model
{
    protected $table = 'evaluasi_wiraniaga';

    protected $fillable = [
        'nama_sales_head',
        'nama_sales',
        'tanggal_masuk',
        'tanggal_evaluasi',
        'grading',
        'jan',
        'feb',
        'mar',
        'apr',
        'mei',
        'jun',
        'total',
        'evaluasi',
        'tanggal_keluar',
        'cabang',
        'user_id'
    ];

    // Fungsi statis untuk menghitung grading agar bisa dipakai di Controller & View
    public static function hitungPeringkat($jan, $feb, $mar)
    {
        $rataRata = ($jan + $feb + $mar) / 3;

        if ($rataRata >= 3) return 'PLATINUM';
        if ($rataRata >= 2) return 'GOLD';
        if ($rataRata >= 1) return 'SILVER';
        if (($jan + $feb + $mar) > 0) return 'TRAINEE';
        return 'FREELANCE';
    }
}
