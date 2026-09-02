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
        Schema::dropIfExists('fakturs');

        Schema::create('fakturs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('cabang')->default('Semua Cabang');
            $table->string('tipe_kendaraan'); 
            $table->integer('tahun')->default(2026);
            $table->string('bulan', 10); 
            $table->integer('bulan_angka')->default(1); 
            $table->integer('jumlah')->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->index(['cabang', 'tahun', 'bulan']);
            $table->index(['tipe_kendaraan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fakturs');
    }
};
