<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StatusLead extends Model
{
    use HasFactory;

    protected $fillable = ['nama_status', 'deskripsi'];
}
