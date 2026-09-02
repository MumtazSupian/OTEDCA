<?php

namespace App\Models\Sales\faktur;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Faktur extends Model
{
    use HasFactory;

    protected $table = 'fakturs';

    protected $fillable = [
        'user_id',
        'cabang',
        'tipe_kendaraan',
        'tahun',
        'bulan',
        'bulan_angka',
        'jumlah',
        'keterangan',
    ];

    public const TIPE_KENDARAAN_LIST = [
        'NEW CARRY',
        'XL7',
        'FRONX',
        'ALL NEW ERTIGA',
        'APV',
        'S-PRESSO',
        'GRAND VITARA',
        'JIMNY 3D',
        'JIMNY 5D',
    ];

    public const BULAN_MAP = [
        1 => 'jan', 2 => 'feb', 3 => 'mar', 4 => 'apr', 5 => 'mei', 6 => 'jun',
        7 => 'jul', 8 => 'agu', 9 => 'sep', 10 => 'okt', 11 => 'nov', 12 => 'des'
    ];

    public const BULAN_NAMA_LENGKAP = [
        'jan' => 'Januari',
        'feb' => 'Februari',
        'mar' => 'Maret',
        'apr' => 'April',
        'mei' => 'Mei',
        'jun' => 'Juni',
        'jul' => 'Juli',
        'agu' => 'Agustus',
        'sep' => 'September',
        'okt' => 'Oktober',
        'nov' => 'November',
        'des' => 'Desember',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getNamaBulanAttribute(): string
    {
        return self::BULAN_NAMA_LENGKAP[strtolower($this->bulan)] ?? strtoupper($this->bulan);
    }
}
