<?php

namespace App\Models\Sales\vsv;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class omTrSalesSO extends Model
{
    use HasFactory;

    protected $connection = 'dms';

    protected $table = 'omTrSalesSO';

    public $timestamps = false;

    protected $fillable = [
        'CompanyCode',
        'BranchCode',
        'SONo',
        'SODate',
        'SalesType',
        'CustomerCode',
        'Salesman',
        'Status',
        'CreatedBy',
        'CreatedDate',
        'LastUpdateBy',
        'LastUpdateDate',
    ];
}
