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
    Schema::create('actual_source_do_inquary', function (Blueprint $table) {
        $table->id();
        $table->enum('source_inquary', [
            'Call In (dari Iklan)',
            'Canvasing',
            'Data Base',
            'Digital Hyperlocal',
            'Digital Non Hyperlocal',
            'Exhibition',
            'Media Digital',
            'Media Elektronik',
            'Mediator',
            'Referensi',
            'Referensi Customer',
            'Showroom Activity',
            'Showroom Walk-in',
            'Website Dealer',
        ])->nullable();

        $table->year('tahun');
        $months = ['jan','feb','mar','apr','mei','jun','jul','agu','sep','okt','nov','des'];
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
        Schema::dropIfExists('actual_source_do_inquary');
    }
};
