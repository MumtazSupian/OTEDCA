<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'units';

    protected $fillable = ['nama', 'deskripsi'];

    public function varians()
    {
        return $this->hasMany(Varian::class, 'unit_id');
    }
}
