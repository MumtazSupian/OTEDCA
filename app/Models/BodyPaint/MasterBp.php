<?php

namespace App\Models\BodyPaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterBp extends Model
{
    use HasFactory;

    protected $table = 'master_bp';

    protected $fillable = [
        'setting_key',
        'setting_value',
    ];
}
