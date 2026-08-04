<?php

namespace App\Models\Sales\vsv\summary;

use Illuminate\Database\Eloquent\Model;

class Summary extends Model
{
    protected $fillable = [
        'operasional',
        'plan_perbaikan',
        'aktual_perbaikan',
        'do_dont',
        'cabang',
        'user_id'
    ];
}
