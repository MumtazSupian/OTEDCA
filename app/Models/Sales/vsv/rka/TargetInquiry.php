<?php

namespace App\Models\Sales\vsv\rka;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class TargetInquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'source_inquiry',
        'tahun',
        'user_id',
        'jan','feb','mar','apr','mei','jun',
        'jul','agu','sep','okt','nov','des',
        'total',
        'cabang'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
