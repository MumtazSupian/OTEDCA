<?php

namespace App\Models\BodyPaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringAsuransiBp extends Model
{
    use HasFactory;

    protected $table = 'monitoring_asuransi_bp';

    protected $fillable = [
        'vin',
        'no_polisi',
        'nama_konsumen',
        'model',
        'perusahaan',
        'tgl_habis',
        'sisa_hari',
        'status_fu',
        'alasan_verbatim',
    ];
}
