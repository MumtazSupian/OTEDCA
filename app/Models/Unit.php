<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = ['nama', 'deskripsi'];

    public function varians()
    {
        return $this->hasMany(Varian::class, 'unit_id');
    }
}
