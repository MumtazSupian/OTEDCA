<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Model;

class Warna extends Model
{
    protected $table = 'warnas';

    protected $fillable = ['nama', 'deskripsi'];
}
