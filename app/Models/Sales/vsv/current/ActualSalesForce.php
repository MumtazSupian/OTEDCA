<?php

namespace App\Models\Sales\vsv\current;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; 

class ActualSalesForce extends Model
{
    use HasFactory;

    protected $table = 'actual_salesforces';

    protected $fillable = [
        'grading',
        'tahun',
        'user_id',
        'jan', 'feb', 'mar', 'apr', 'mei', 'jun',
        'jul', 'agu', 'sep', 'okt', 'nov', 'des',
        'total',
        'cabang'
    ];

    /**
     * Relasi ke model User
     * Digunakan untuk identifikasi siapa yang menginput data (terutama untuk filter role SH)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}