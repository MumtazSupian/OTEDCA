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
        if (!Schema::hasTable('in_units')) {
            Schema::create('in_units', function (Blueprint $table) {
                $table->id();
                $table->string('nama_driver')->nullable();
                $table->date('tanggal')->nullable();
                $table->string('type')->nullable();
                $table->string('warna')->nullable();
                $table->string('no_rangka')->nullable();
                $table->string('no_mesin')->nullable();
                $table->string('lokasi_pengambilan')->nullable();
                $table->unsignedBigInteger('cabang_id')->nullable();
                $table->foreign('cabang_id')->references('id')->on('cabangs')->onDelete('set null');
                $table->string('cekits')->nullable();
                $table->time('jam_kedatangan')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('in_units');
    }
};
