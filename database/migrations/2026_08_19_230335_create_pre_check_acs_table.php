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
        Schema::create('pre_check_acs', function (Blueprint $table) {
            $table->id();
            
            // General
            $table->string('jenis_pemeriksaan')->nullable(); // PRE CHECK
            $table->string('no_polisi')->nullable();
            $table->string('cabang')->nullable();
            $table->string('teknisi')->nullable();
            $table->string('sa')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('tipe_kendaraan')->nullable();
            
            // Hasil Pengukuran (Form Check)
            $table->string('high_pressure')->nullable();
            $table->string('low_pressure')->nullable();
            $table->string('suhu_outlet')->nullable();
            $table->string('wind_speed')->nullable();
            
            // Saran & Perbaikan
            $table->text('pemeriksaan_tambahan')->nullable();
            $table->string('rekomendasi_perawatan')->nullable(); // dropdown
            $table->string('estimasi_penggantian_part')->nullable(); // text
            
            // Dokumentasi Foto
            $table->string('foto_kendaraan')->nullable(); // Path foto
            $table->string('keterangan_foto')->nullable();
            
            // Status Approve (For List Data table)
            $table->string('status_approve')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_check_acs');
    }
};
