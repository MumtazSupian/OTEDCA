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
        Schema::create('actual_spk_by_type', function (Blueprint $table) {
            $table->id();

            // enum mobil_type
            // 1. Kategori (Commercial / Passenger)
            $table->enum('jenis_unit', ['Commercial', 'Passenger']);

            // 2. Type Unit (Strict Enum)
            $table->enum('type_unit', [
                'NEW CARRY',
                'APV BLIND VAN',
                'ERTIGA',
                'XL7',
                'SPRESO',
                'IGNIS',
                'e-VITARA',
                'GRAND VITARA',
                'JIMNY 3D',
                'JIMNY 5D',
                'FRONX',
                'BALENO'
            ]);

            $table->year('tahun');

            // loop bulan
            $months = [
                'jan',
                'feb',
                'mar',
                'apr',
                'mei',
                'jun',
                'jul',
                'agu',
                'sep',
                'okt',
                'nov',
                'des'
            ];

            foreach ($months as $month) {
                $table->integer($month)->default(0);
            }

            $table->integer('total')->default(0);
            $table->string('cabang');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actual_spk_by_type');
    }
};
