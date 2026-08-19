<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesLead extends Model
{
    protected $fillable = ['nama', 'deskripsi', 'cabang'];
}
