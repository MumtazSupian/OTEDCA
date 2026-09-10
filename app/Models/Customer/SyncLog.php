<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

class SyncLog extends Model
{
    protected $table = 'sync_logs';

    protected $fillable = [
        'type',
        'mulai',
        'selesai',
        'status',
        'progress',
        'pair_baru',
        'auto_resolve',
        'error',
    ];

    protected $casts = [
        'mulai' => 'datetime',
        'selesai' => 'datetime',
        'pair_baru' => 'integer',
        'auto_resolve' => 'integer',
    ];
}
