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
        Schema::table('stocks', function (Blueprint $table) {
            if (!Schema::hasColumn('stocks', 'nama_mobil')) {
                $table->string('nama_mobil')->nullable()->after('kode_mobil');
            }
            if (!Schema::hasColumn('stocks', 'warna')) {
                $table->string('warna')->nullable()->after('nama_mobil');
            }
            if (!Schema::hasColumn('stocks', 'lokasi')) {
                $table->string('lokasi')->nullable()->after('hpp');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stocks', function (Blueprint $table) {
            if (Schema::hasColumn('stocks', 'nama_mobil')) {
                $table->dropColumn('nama_mobil');
            }
            if (Schema::hasColumn('stocks', 'warna')) {
                $table->dropColumn('warna');
            }
            if (Schema::hasColumn('stocks', 'lokasi')) {
                $table->dropColumn('lokasi');
            }
        });
    }
};
