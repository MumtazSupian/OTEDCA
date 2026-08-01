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
            if (!Schema::hasColumn('in_units', 'unit_id')) {
                $table->unsignedBigInteger('unit_id')->nullable();
                $table->foreign('unit_id')->references('id')->on('units')->onDelete('set null');
            }
            if (!Schema::hasColumn('in_units', 'varian_id')) {
                $table->unsignedBigInteger('varian_id')->nullable();
                $table->foreign('varian_id')->references('id')->on('varians')->onDelete('set null');
            }
            if (!Schema::hasColumn('in_units', 'gudang_id')) {
                $table->unsignedBigInteger('gudang_id')->nullable();
                $table->foreign('gudang_id')->references('id')->on('gudangs')->onDelete('set null');
            }
            if (!Schema::hasColumn('in_units', 'cabang_id')) {
                $table->unsignedBigInteger('cabang_id')->nullable();
                $table->foreign('cabang_id')->references('id')->on('cabangs')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('in_units', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
            $table->dropColumn('unit_id');
            $table->dropForeign(['varian_id']);
            $table->dropColumn('varian_id');
            $table->dropForeign(['gudang_id']);
            $table->dropColumn('gudang_id');
            $table->dropForeign(['cabang_id']);
            $table->dropColumn('cabang_id');
        });
    }
};
