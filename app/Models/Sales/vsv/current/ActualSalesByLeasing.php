<?php

namespace App\Models\Sales\vsv\current;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ActualSalesByLeasing extends Model
{
    protected $table = 'actual_sales_by_leasing';

    protected $fillable = [
        'leasing_name',
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
        'cabang',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
