<?php

namespace App\Models\Sales\vsv\current;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ActualDoByType extends Model
{
    use HasFactory;

    protected $table = 'actual_do_by_type';

    protected $fillable = [
        'jenis_unit',
        'type_unit',
        'tahun',
        'user_id',
        'jan', 'feb', 'mar', 'apr', 'mei', 'jun',
        'jul', 'agu', 'sep', 'okt', 'nov', 'des',
        'total',
        'cabang'
    ];

    /*
     * Relasi ke model User
     * Digunakan untuk identifikasi siapa yang menginput data (terutama untuk role SH)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}