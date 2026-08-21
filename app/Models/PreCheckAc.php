<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreCheckAc extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis_pemeriksaan',
        'no_spk',
        'no_polisi',
        'cabang',
        'teknisi',
        'sa',
        'tanggal',
        'tipe_kendaraan',
        'high_pressure',
        'low_pressure',
        'suhu_outlet',
        'wind_speed',
        'pemeriksaan_tambahan',
        'rekomendasi_perawatan',
        'estimasi_penggantian_part',
        'foto_kendaraan',
        'keterangan_foto',
        'status_approve',
    ];
}
