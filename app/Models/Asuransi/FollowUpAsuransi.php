<?php

namespace App\Models\Asuransi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowUpAsuransi extends Model
{
    use HasFactory;

    protected $table = 'follow_up_asuransi';

    protected $fillable = [
        'vin',
        'status',
        'tipe',
        'konsumen',
        'no_hp',
        'kendaraan',
        'asuransi_lama',
        'sales',
        'next_fu',
        'catatan',
        'is_overdue',
    ];
}
