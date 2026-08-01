<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Varian extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['nama', 'deskripsi', 'unit_id'];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'varian_id');
    }
}
