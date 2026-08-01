<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Isi created_at & updated_at untuk record yang sudah ada (NULL).
     */
    public function up(): void
    {
        DB::table('in_units')
            ->whereNull('created_at')
            ->update([
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak bisa di-reverse karena kita tidak tahu nilai aslinya
    }
};
