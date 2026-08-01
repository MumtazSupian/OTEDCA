<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piutang extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch',
        'tipe_konsumen',
        'perusahaan_id',
        'nama_konsumen',
        'nama_asuransi',
        'tgl_bukti',
        'no_bukti',
        'saldo_awal',
        'debet',

        'kredit',
        'kredit_2',
        'kredit_3',

        'tgl_bukti_rek',
        'no_bukti_rek',
        'keterangan',

        'tgl_bukti_rek_2',
        'no_bukti_rek_2',
        'keterangan_2',

        'tgl_bukti_rek_3',
        'no_bukti_rek_3',
        'keterangan_3',

        'saldo_akhir',
        'no_polisi',
        'no_polis',
        'spk_type',
        'no_spk',
    ];

    protected $casts = [
        'tgl_bukti' => 'date',
        'tgl_bukti_rek' => 'date',
        'tgl_bukti_rek_2' => 'date',
        'tgl_bukti_rek_3' => 'date',

        'saldo_awal' => 'decimal:2',
        'debet' => 'decimal:2',

        'kredit' => 'decimal:2',
        'kredit_2' => 'decimal:2',
        'kredit_3' => 'decimal:2',

        'saldo_akhir' => 'decimal:2',
    ];
    
    public function perusahaan() {
        return $this->belongsTo(Perusahaan::class, 'perusahaan_id');
    }
}

