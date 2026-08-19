<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SumberLead extends Model
{
    use HasFactory;

    protected $fillable = ['nama_sumber', 'deskripsi'];

    public function budgets()
    {
        return $this->hasMany(BudgetLead::class, 'sumber_id');
    }
}
