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
        Schema::table('in_units', function (Blueprint $table) {
            // Hapus FK dan kolom lama yang tidak dipakai lagi
            if (Schema::hasColumn('in_units', 'unit_id')) {
                $table->dropForeign(['unit_id']);
                $table->dropColumn('unit_id');
            }
            if (Schema::hasColumn('in_units', 'varian_id')) {
                $table->dropForeign(['varian_id']);
                $table->dropColumn('varian_id');
            }
            if (Schema::hasColumn('in_units', 'gudang_id')) {
                $table->dropForeign(['gudang_id']);
                $table->dropColumn('gudang_id');
            }
            if (Schema::hasColumn('in_units', 'group_model')) {
                $table->dropColumn('group_model');
            }
            if (Schema::hasColumn('in_units', 'sales_model')) {
                $table->dropColumn('sales_model');
            }
        });

        Schema::table('in_units', function (Blueprint $table) {
            // Tambah field-field baru (nullable agar aman jika ada data lama)
            // Gunakan hasColumn agar idempotent
            if (!Schema::hasColumn('in_units', 'nama_driver')) {
                $table->string('nama_driver')->nullable()->after('id');
            }
            if (!Schema::hasColumn('in_units', 'tanggal')) {
                $table->date('tanggal')->nullable()->after('nama_driver');
            }
            if (!Schema::hasColumn('in_units', 'type')) {
                $table->string('type')->nullable()->after('tanggal');
            }
            if (!Schema::hasColumn('in_units', 'warna')) {
                $table->string('warna')->nullable()->after('type');
            }
            if (!Schema::hasColumn('in_units', 'no_rangka')) {
                $table->string('no_rangka')->nullable()->after('warna');
            }
            if (!Schema::hasColumn('in_units', 'no_mesin')) {
                $table->string('no_mesin')->nullable()->after('no_rangka');
            }
            if (!Schema::hasColumn('in_units', 'lokasi_pengambilan')) {
                $table->string('lokasi_pengambilan')->nullable()->after('no_mesin');
            }
            if (!Schema::hasColumn('in_units', 'cabang_id')) {
                $table->unsignedBigInteger('cabang_id')->nullable()->after('lokasi_pengambilan');
                $table->foreign('cabang_id')->references('id')->on('cabangs')->onDelete('set null');
            }
            if (!Schema::hasColumn('in_units', 'cekits')) {
                $table->string('cekits')->nullable()->after('cabang_id');
            }
            if (!Schema::hasColumn('in_units', 'jam_kedatangan')) {
                $table->time('jam_kedatangan')->nullable()->after('cekits');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('in_units', function (Blueprint $table) {
            $table->dropColumn([
                'nama_driver', 'tanggal', 'type',
                'warna', 'no_rangka', 'no_mesin', 'lokasi_pengambilan',
                'cekits', 'jam_kedatangan',
            ]);

            if (Schema::hasColumn('in_units', 'cabang_id')) {
                $table->dropForeign(['cabang_id']);
                $table->dropColumn('cabang_id');
            }
        });
    }
};
