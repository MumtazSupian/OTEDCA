<?php

namespace App\Models\Sales\vsv\current;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ActualSourceInquary extends Model
{
    use HasFactory;

    // Nama tabel harus sesuai dengan yang ada di database
    protected $table = 'actual_source_inquary';

    protected $fillable = [
        'source_inquary',
        'tahun',
        'user_id',
        'cabang',
        'jan', 'feb', 'mar', 'apr', 'mei', 'jun',
        'jul', 'agu', 'sep', 'okt', 'nov', 'des',
        'total'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}