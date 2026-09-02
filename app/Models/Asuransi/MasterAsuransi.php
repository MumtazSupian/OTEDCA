<?php

namespace App\Models\Asuransi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterAsuransi extends Model
{
    use HasFactory;

    protected $table = 'master_asuransi';

    protected $fillable = [
        'nama_perusahaan',
        'urutan',
        'status',
    ];

    /**
     * Default list perusahaan asuransi
     */
    public static function getDefaultPerusahaan()
    {
        return [];
    }
}
