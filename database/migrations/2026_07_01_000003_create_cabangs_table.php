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
        Schema::create('cabangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });
        // Seed default cabang names
        DB::table('cabangs')->insert([
            ['nama' => 'Ciawi', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Cianjur', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Cinere', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Jatiasih', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'HO', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Cipanas', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cabangs');
    }
};
