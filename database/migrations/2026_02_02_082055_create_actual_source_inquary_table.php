<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('actual_source_inquary', function (Blueprint $table) {
            $table->id();

            // enum source_inquiry
            $table->enum('source_inquary', [
                'Call In (dari Iklan)',
                'Canvasing',
                'Data Base',
                'Digital Hyperlocal',
                'Digital Non Hyperlocal',
                'Exibition',
                'Media Digital',
                'Media Elektronik',
                'Mediator',
                'Referensi',
                'Referensi Customer',
                'Showroom Activity',
                'Showroom Walk In',
                'Website Dealer',
            ])->nullable();

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

    public function down(): void
    {
        Schema::dropIfExists('actual_source_inquary');
    }
};
