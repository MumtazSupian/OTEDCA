<?php

namespace App\Models\Sales\vsv\current;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ActualDoSalesForce extends Model
{
    protected $table = 'actual_do_salesforces';

    protected $fillable = [
        'grading',
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
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
