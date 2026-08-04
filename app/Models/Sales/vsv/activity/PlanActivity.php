<?php

namespace App\Models\Sales\vsv\activity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PlanActivity extends Model
{
    use HasFactory;
    protected $table = 'plan_activities';
    protected $fillable = [
        'user_id',
        'cabang',
        'jenis_activity',
        'activity',
        'platform_lokasi',
        'jenis_unit',
        'type_unit',
        'tanggal',
        'jam',
        'pic',
        'jml_sales_shift',
        'target_p',
        'target_hp',
        'target_spk',
        'actual_p',
        'actual_hp',
        'actual_spk',
        'actual_do',
        'total_cost',
        'cost_p',
        'cost_spk',
        'cost_do',
        'keterangan'
    ];
}
