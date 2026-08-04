<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('actual_salesforces', function (Blueprint $table) {
            $table->id();

            // enum grading
            $table->enum('grading', [
                'PLATINUM',
                'GOLD',
                'SILVER',
                'TRAINEE',
                'FREELANCE',
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
        Schema::dropIfExists('actual_salesforces');
    }
};
