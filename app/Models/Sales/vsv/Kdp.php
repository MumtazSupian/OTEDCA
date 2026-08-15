<?php

namespace App\Models\Sales\vsv;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Exception;

class Kdp extends Model
{
    use HasFactory;

    protected $connection = 'dms';

    protected $table = 'pmKDP';

    public $timestamps = false;

    protected $fillable = [
        'InquiryNumber',
        'BranchCode',
        'CompanyCode',
        'EmployeeID',
        'SpvEmployeeID',
        'InquiryDate',
        'OutletID',
        'StatusProspek',
        'PerolehanData',
        'NamaProspek',
        'AlamatProspek',
        'TelpRumah',
        'CityID',
        'NamaPerusahaan',
        'AlamatPerusahaan',
        'Jabatan',
        'Handphone',
        'Faximile',
        'Email',
        'TipeKendaraan',
        'Variant',
        'Transmisi',
        'ColourCode',
        'CaraPembayaran',
        'TestDrive',
        'QuantityInquiry',
        'LastProgress',
        'LastUpdateStatus',
        'SPKDate',
        'LostCaseDate',
        'LostCaseCategory',
        'LostCaseReasonID',
        'LostCaseOtherReason',
        'LostCaseVoiceOfCustomer',
        'CreationDate',
        'CreatedBy',
        'LastUpdateBy',
        'LastUpdateDate',
        'Leasing',
        'DownPayment',
        'Tenor',
        'MerkLain'
    ];

    // =========================================================================
    // Mencegah kode lain melakukan Create, Update, atau Delete secara tidak sengaja
    // =========================================================================

    public function save(array $options = [])
    {
        throw new Exception("AMANKAN DB KANTOR: Model KDP hanya boleh untuk membaca data (Read-Only)!");
    }

    public function update(array $attributes = [], array $options = [])
    {
        throw new Exception("AMANKAN DB KANTOR: Model KDP hanya boleh untuk membaca data (Read-Only)!");
    }

    public function delete()
    {
        throw new Exception("AMANKAN DB KANTOR: Model KDP hanya boleh untuk membaca data (Read-Only)!");
    }
}

