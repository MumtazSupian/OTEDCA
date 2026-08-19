<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_hp',
        'nama',
        'alamat',
        'tanggal',
        'cabang',
        'sumber_id',
        'unit_id',
        'status_id',
        'respon_id',
        'spv_id',
        'sales_id',
        'update_1',
        'update_2',
        'update_3',
        'bukti_screenshot',
    ];

    public function sumber()
    {
        return $this->belongsTo(SumberLead::class, 'sumber_id');
    }

    public function unit()
    {
        return $this->belongsTo(UnitLead::class, 'unit_id');
    }

    public function status()
    {
        return $this->belongsTo(StatusLead::class, 'status_id');
    }

    public function respon()
    {
        return $this->belongsTo(ResponLead::class, 'respon_id');
    }

    public function spv()
    {
        return $this->belongsTo(SpvLead::class, 'spv_id');
    }

    public function sales()
    {
        return $this->belongsTo(SalesLead::class, 'sales_id');
    }
}
