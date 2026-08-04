<?php

namespace App\Models\Sales\vsv;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class omTrSalesReqDetail extends Model
{
    use HasFactory;

    protected $connection = 'dms';

    protected $table = 'omTrSalesReqDetail';

    public $timestamps = false;

    protected $guarded = [];
}
