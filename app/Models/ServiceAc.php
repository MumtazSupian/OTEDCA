<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceAc extends Model
{
    use HasFactory;

    protected $fillable = [
        'cabang',
        'periode',
        'unit_entry_bulan',
        'unit_entry_hari_ini',
        'unit_entry_target',
        'unit_spooring_bulan',
        'unit_spooring_hari_ini',
        'unit_spooring_target',
        'unit_ac_bulan',
        'unit_ac_hari_ini',
        'unit_ac_target',
    ];
}
