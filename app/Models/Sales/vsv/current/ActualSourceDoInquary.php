<?php

namespace App\Models\Sales\vsv\current;

use Illuminate\Database\Eloquent\Model;
use App\Models\User; 

class ActualSourceDoInquary extends Model
{
    protected $table = 'actual_source_do_inquary';

    protected $fillable = [
        'user_id',
        'source_inquary',
        'tahun',
        'jan',
        'feb',
        'mar',
        'apr',
        'mei',
        'jun',
        'jul',
        'agu',
        'sep',
        'okt',
        'nov',
        'des',
        'total',
        'cabang'
    ];

    public function user()
    {
        // Sekarang User::class akan merujuk ke App\Models\User dengan benar
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}