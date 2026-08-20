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
        Schema::table('post_check_acs', function (Blueprint $table) {
            // Drop the old string columns
            $table->dropColumn(['foto_kendaraan', 'keterangan_foto']);
        });
        
        Schema::table('post_check_acs', function (Blueprint $table) {
            // Create the new longText columns (longText is better than json for broad MySQL/MariaDB compatibility)
            $table->longText('foto_kendaraan')->nullable(); // Will store JSON array of image objects
            $table->longText('keterangan_foto')->nullable(); // Might not need this if we store everything in foto_kendaraan, but keep it for backwards compatibility if needed.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('post_check_acs', function (Blueprint $table) {
            $table->dropColumn(['foto_kendaraan', 'keterangan_foto']);
        });
        Schema::table('post_check_acs', function (Blueprint $table) {
            $table->string('foto_kendaraan')->nullable();
            $table->string('keterangan_foto')->nullable();
        });
    }
};
