<?php

namespace App\Models\Sales\vsv\leasing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AktualPo extends Model
{
    use HasFactory;

    protected $table = 'aktual_po';

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
