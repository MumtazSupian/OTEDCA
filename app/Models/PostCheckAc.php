<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCheckAc extends Model
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
        'pre_high_pressure',
        'pre_low_pressure',
        'pre_suhu_outlet',
        'pre_wind_speed',
        'post_high_pressure',
        'post_low_pressure',
        'post_suhu_outlet',
        'post_wind_speed',
        'catatan_tambahan',
        'perawatan',
        'penggantian',
        'foto_kendaraan',
        'keterangan_foto',
        'status_approve',
    ];
}
