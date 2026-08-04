<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asuransi extends Model
{
    use HasFactory;

    protected $table = 'asuransis';

    protected $fillable = [
        'nama',
        'deskripsi',
    ];
}
