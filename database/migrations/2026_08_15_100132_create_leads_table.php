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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('no_hp');
            $table->string('nama')->nullable(); // Ditambahkan saat update oleh Sales
            $table->date('tanggal');
            $table->string('cabang'); // e.g. 'ciawi', 'cianjur', 'cinere', 'jatiasih'

            // Relasi ke tabel master (sementara menggunakan string, nanti bisa direlasikan)
            $table->string('sumber_id')->nullable();
            $table->string('unit_id')->nullable();
            $table->string('status_id')->nullable();
            $table->string('spv_id')->nullable();
            $table->string('sales_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
