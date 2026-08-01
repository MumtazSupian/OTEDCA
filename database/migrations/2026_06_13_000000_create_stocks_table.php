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
        if (!Schema::hasTable('stocks')) {
            Schema::create('stocks', function (Blueprint $table) {
                $table->id();
                $table->string('no_do')->nullable();
                $table->date('tanggal_do')->nullable();
                $table->unsignedBigInteger('unit_id')->nullable();
                $table->foreign('unit_id')->references('id')->on('units')->onDelete('set null');
                $table->unsignedBigInteger('varian_id')->nullable();
                $table->foreign('varian_id')->references('id')->on('varians')->onDelete('set null');
                $table->unsignedBigInteger('gudang_id')->nullable();
                $table->foreign('gudang_id')->references('id')->on('gudangs')->onDelete('set null');
                $table->unsignedBigInteger('cabang_id')->nullable();
                $table->foreign('cabang_id')->references('id')->on('cabangs')->onDelete('set null');
                $table->unsignedBigInteger('warna_id')->nullable();
                $table->foreign('warna_id')->references('id')->on('warnas')->onDelete('set null');
                $table->string('kode_mobil')->nullable();
                $table->integer('tahun')->nullable();
                $table->string('chassis_code')->nullable();
                $table->string('norangka')->nullable();
                $table->string('enginecode')->nullable();
                $table->string('nomesin')->nullable();
                $table->string('faktur')->nullable();
                $table->string('bln_naik_faktur')->nullable();
                $table->bigInteger('harga')->nullable();
                $table->bigInteger('kpt_kf')->nullable();
                $table->bigInteger('acs2')->nullable();
                $table->bigInteger('subsidi')->nullable();
                $table->bigInteger('hpp')->nullable();
                $table->string('estimasi_unit_masuk_gudang_dca')->nullable();
                $table->string('status')->nullable();
                $table->string('lain_lain')->nullable();
                $table->string('penjualan')->nullable();
                $table->string('tanggal_matching_do')->nullable();
                $table->string('cabang')->nullable();
                $table->string('keterangan')->nullable();
                $table->string('unit')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
