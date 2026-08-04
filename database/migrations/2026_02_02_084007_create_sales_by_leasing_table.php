<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('actual_sales_by_leasing', function (Blueprint $table) {
            $table->id();

            // enum leasing
            $table->enum('leasing_name', [
                'tunai',
                'suzuki_finance',
                'bca_finance',
                'kbb_bca',
                'mandiri_tunas_finance',
                'kbb_mandiri',
                'bsi',
                'mandiri_utama_finance',
                'indomobil_finance',
                'adira_finance',
                'bni_finance',
                'maybank',
                'oto_multiartha_finance',
                'niaga_finance',
                'clipan_finance',
                'lain_lain'
            ]);

            $table->year('tahun');

            // bulan (loop)
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
        Schema::dropIfExists('actual_sales_by_leasing');
    }
};
