<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('target_do_units', function (Blueprint $table) {
            $table->id();

            $table->enum('jenis_unit', ['Commercial', 'Passenger']);
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

            $table->year('tahun')->nullable();

            $bulan = [
                'jan','feb','mar','apr','mei','jun',
                'jul','agu','sep','okt','nov','des'
            ];

            foreach ($bulan as $b) {
                $table->integer($b)->default(0);
            }

            $table->integer('total')->default(0);

            $table->string('cabang');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('target_do_units');
    }
};
