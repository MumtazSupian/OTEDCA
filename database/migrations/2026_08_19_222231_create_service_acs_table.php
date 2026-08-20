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
        Schema::create('service_acs', function (Blueprint $table) {
            $table->id();
            $table->string('cabang'); // CIAWI, CIANJUR, CINERE, JATIASIH
            $table->date('periode'); // e.g. 2026-08-01 to represent August 2026

            // Unit Entry Service
            $table->integer('unit_entry_bulan')->default(0);
            $table->integer('unit_entry_hari_ini')->default(0);
            $table->integer('unit_entry_target')->default(0);

            // Unit Spooring Balancing
            $table->integer('unit_spooring_bulan')->default(0);
            $table->integer('unit_spooring_hari_ini')->default(0);
            $table->integer('unit_spooring_target')->default(0);

            // Unit AC
            $table->integer('unit_ac_bulan')->default(0);
            $table->integer('unit_ac_hari_ini')->default(0);
            $table->integer('unit_ac_target')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_acs');
    }
};
