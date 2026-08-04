<?php

namespace App\Models\Sales\vsv;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class omTrSalesSOModel extends Model
{
    use HasFactory;

    protected $connection = 'dms';

    protected $table = 'omTrSalesSOModel';

    public $timestamps = false;

    protected $fillable = [
        'CompanyCode',
        'BranchCode',
        'SONo',
        'SalesModelCode',
        'SalesModelYear',
        'QuantitySO',
        'QuantityDO',
    ];
}
