<?php

namespace App\Models\Sales\vsv\leasing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AktualAplikasiIn extends Model
{
    use HasFactory;

    protected $table = 'aktual_aplikasi_in';

    protected $fillable = [
        'leasing',
        'tahun',
        'user_id',
        'jan','feb','mar','apr','mei','jun',
        'jul','agu','sep','okt','nov','des',
        'total',
        'cabang'
    ];
}
