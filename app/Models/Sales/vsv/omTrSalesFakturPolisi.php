<?php

namespace App\Models\Sales\vsv;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class omTrSalesFakturPolisi extends Model
{
    use HasFactory;

    protected $connection = 'dms';

    protected $table = 'omTrSalesFakturPolisi';

    public $timestamps = false;

    protected $fillable = [
        'CompanyCode',
        'BranchCode',
        'FakturPolisiNo',
        'SalesModelCode',
        'SalesModelYear',
        'ColourCode',
        'ChassisCode',
        'ChassisNo',
        'EngineCode',
        'EngineNo',
        'IsBlanko',
        'FakturPolisiProcess',
        'SJImniNo',
        'DOImniNo',
        'ReqNo',
        'CreatedBy',
        'CreatedDate',
        'LastUpdateBy',
        'Status',
        'IsManual',
    ];
}
