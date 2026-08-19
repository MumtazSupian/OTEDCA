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
        Schema::create('budget_leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sumber_id')->constrained('sumber_leads')->onDelete('cascade');
            $table->string('budget');
            $table->string('bulan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_leads');
    }
};
