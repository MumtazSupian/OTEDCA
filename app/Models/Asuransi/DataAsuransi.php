<?php

namespace App\Models\Asuransi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataAsuransi extends Model
{
    use HasFactory;

    protected $table = 'data_asuransi';

    protected $fillable = [
        'vin',
        'tgl_billing',
        'pembiayaan',
        'model',
        'konsumen',
        'kota',
        'jenis',
        'asuransi',
        'periode_mulai',
        'periode_selesai',
        'status',
        'perusahaan',
        'catatan',
    ];
}
