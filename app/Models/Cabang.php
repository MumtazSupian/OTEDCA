<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cabang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cabangs';

    protected $fillable = ['nama'];

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'cabang_id');
    }
}
