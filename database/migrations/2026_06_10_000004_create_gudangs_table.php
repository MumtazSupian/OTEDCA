<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('gudangs')) {
            Schema::create('gudangs', function (Blueprint $table) {
                $table->id();
                $table->string('nama');
                $table->timestamps();
            });

            // Seed default gudang names
            DB::table('gudangs')->insert([
                ['nama' => 'Ciawi', 'created_at' => now(), 'updated_at' => now()],
                ['nama' => 'Cianjur', 'created_at' => now(), 'updated_at' => now()],
                ['nama' => 'Cinere', 'created_at' => now(), 'updated_at' => now()],
                ['nama' => 'Jatiasih', 'created_at' => now(), 'updated_at' => now()],
                ['nama' => 'Cikarang', 'created_at' => now(), 'updated_at' => now()],
                ['nama' => 'Tambun', 'created_at' => now(), 'updated_at' => now()],
                ['nama' => 'Cipanas', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gudangs');
    }
};
