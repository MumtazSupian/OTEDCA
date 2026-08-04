<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dashboards', function (Blueprint $table) {
            $table->id();
            $table->string('cabang');
            $table->string('kategori');
            $table->string('item_name');

            $table->integer('trg_1')->default(0);
            $table->integer('act_1')->default(0);
            $table->integer('act_2')->default(0);
            $table->integer('act_3')->default(0);

            $table->string('bulan')->default('March 2026');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dashboards');
    }
};
