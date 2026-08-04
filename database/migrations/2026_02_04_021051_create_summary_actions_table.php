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
        Schema::create('summary_actions', function (Blueprint $table) {
        $table->id();
        $table->string('operasional');
        $table->text('kondisi_yang_ada')->nullable();
        $table->text('action_perbaikan')->nullable();
        $table->enum('do_dont', ['X', 'V'])->nullable();

        $table->string('cabang');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('summary_actions');
    }
};
