<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BudgetLead extends Model
{
    use HasFactory;

    protected $fillable = ['sumber_id', 'budget', 'bulan'];

    public function sumber()
    {
        return $this->belongsTo(SumberLead::class, 'sumber_id');
    }
}
