<?php

namespace App\Models\Asuransi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringFollowUp extends Model
{
    use HasFactory;

    protected $table = 'monitoring_follow_up';

    protected $fillable = [
        'spv_id',
        'spv_name',
        'sales_id',
        'sales_name',
        'total',
        'open',
        'overdue',
        'berhasil',
        'tidak_berminat',
        'kontak_dicatat',
        'kontak_rate',
        'response_rate',
        'terakhir_aktif',
    ];
}
