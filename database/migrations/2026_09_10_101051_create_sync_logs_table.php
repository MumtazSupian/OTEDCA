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
        Schema::create('sync_logs', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('Incremental'); // Incremental, Full, Manual
            $table->dateTime('mulai')->nullable();
            $table->dateTime('selesai')->nullable();
            $table->string('status')->default('completed'); // completed, in_progress, failed
            $table->string('progress')->nullable(); // e.g. '97 records'
            $table->integer('pair_baru')->nullable(); // e.g. 242
            $table->integer('auto_resolve')->nullable(); // e.g. 4
            $table->text('error')->nullable(); // e.g. 'Sync OK, detection error: Undefined array key 0'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sync_logs');
    }
};
