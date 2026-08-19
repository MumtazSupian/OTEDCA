<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnitLead extends Model
{
    use HasFactory;

    protected $fillable = ['nama_unit', 'deskripsi'];
}
