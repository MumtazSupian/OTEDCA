<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Model;

class InUnit extends Model
{
    protected $table = 'in_units';

    public $timestamps = true;

    protected $fillable = [
        'nama_driver',
        'tanggal',
        'type',
        'warna',
        'no_rangka',
        'no_mesin',
        'lokasi_pengambilan',
        'cabang_id',
        'cekits',
        'jam_kedatangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }
}
