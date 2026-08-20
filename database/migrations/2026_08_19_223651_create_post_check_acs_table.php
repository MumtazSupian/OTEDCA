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
        Schema::create('post_check_acs', function (Blueprint $table) {
            $table->id();
            
            // General
            $table->string('jenis_pemeriksaan')->nullable(); // POST CHECK / PRE CHECK
            $table->string('no_polisi')->nullable();
            $table->string('cabang')->nullable();
            $table->string('teknisi')->nullable();
            $table->string('sa')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('tipe_kendaraan')->nullable();
            
            // Form Pre Check
            $table->string('pre_high_pressure')->nullable();
            $table->string('pre_low_pressure')->nullable();
            $table->string('pre_suhu_outlet')->nullable();
            $table->string('pre_wind_speed')->nullable();
            
            // Form Post Check
            $table->string('post_high_pressure')->nullable();
            $table->string('post_low_pressure')->nullable();
            $table->string('post_suhu_outlet')->nullable();
            $table->string('post_wind_speed')->nullable();
            
            // Tambahan Pemeriksaan
            $table->text('catatan_tambahan')->nullable();
            
            // Hasil Pekerjaan
            $table->string('perawatan')->nullable(); // dropdown
            $table->string('penggantian')->nullable(); // text
            
            // Upload Foto Kendaraan
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
        Schema::dropIfExists('post_check_acs');
    }
};
