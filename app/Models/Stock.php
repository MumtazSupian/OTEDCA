<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'no_do',
        'tanggal_do',
        'kode_mobil',
        'nama_mobil',
        'varian',
        'warna',
        'tahun',
        'chassis_code',
        'norangka',
        'enginecode',
        'nomesin',
        'faktur',
        'bln_naik_faktur',
        'harga',
        'kpt_kf',
        'acs2',
        'subsidi',
        'hpp',
        'lokasi',
        'estimasi_unit_masuk_gudang_dca',
        'status',
        'lain_lain',
        'penjualan',
        'tanggal_matching_do',
        'cabang',
        'keterangan',
        'unit',
        // foreign keys
        'unit_id',
        'varian_id',
        'warna_id',
        'gudang_id',
        'cabang_id',
    ];
    protected $casts = [
        'tanggal_do' => 'date',
        'tanggal_matching_do' => 'date',
    ];

    // Relationships
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function varian()
    {
        return $this->belongsTo(Varian::class, 'varian_id');
    }

    public function warna()
    {
        return $this->belongsTo(Warna::class, 'warna_id');
    }

    public function gudang()
    {
        return $this->belongsTo(Gudang::class, 'gudang_id');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id');
    }

}
