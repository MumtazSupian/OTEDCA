<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            if (!Schema::hasColumn('leads', 'alamat')) {
                $table->string('alamat')->nullable()->after('nama');
            }
            if (!Schema::hasColumn('leads', 'respon_id')) {
                $table->string('respon_id')->nullable()->after('status_id');
            }
            if (!Schema::hasColumn('leads', 'update_1')) {
                $table->text('update_1')->nullable();
            }
            if (!Schema::hasColumn('leads', 'update_2')) {
                $table->text('update_2')->nullable();
            }
            if (!Schema::hasColumn('leads', 'update_3')) {
                $table->text('update_3')->nullable();
            }
            if (!Schema::hasColumn('leads', 'bukti_screenshot')) {
                $table->string('bukti_screenshot')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn([
                'alamat', 
                'respon_id', 
                'update_1', 
                'update_2', 
                'update_3', 
                'bukti_screenshot'
            ]);
        });
    }
};
