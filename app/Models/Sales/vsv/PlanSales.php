<?php

namespace App\Models\Sales\vsv;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanSales extends Model
{
    use HasFactory;

    protected $connection = 'dms';

    protected $table = 'pmMstPlanSales';

    public $timestamps = false;

    protected $fillable = [
        'CompanyCode',
        'BranchCode',
        'SpvEmployeeID',
        'SourceCode',
        'DetailCode',
        'DetailName',
        'Year',
        'Month',
        'SourceName',

        // Week 1 - 5
        'DO_Week1', 'SPK_Week1', 'INQ_Week1',
        'DO_Week2', 'SPK_Week2', 'INQ_Week2',
        'DO_Week3', 'SPK_Week3', 'INQ_Week3',
        'DO_Week4', 'SPK_Week4', 'INQ_Week4',
        'DO_Week5', 'SPK_Week5', 'INQ_Week5',

        // Audit Trail
        'CreatedBy',
        'CreatedDate',
        'UpdatedBy',
        'UpdatedDate',
    ];
}