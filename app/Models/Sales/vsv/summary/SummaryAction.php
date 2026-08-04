<?php

namespace App\Models\Sales\vsv\summary;

use Illuminate\Database\Eloquent\Model;

class SummaryAction extends Model
{
     protected $fillable = [
        'operasional',
        'kondisi_yang_ada',
        'action_perbaikan',
        'do_dont',
        'cabang',
        'user_id'
    ];
}
