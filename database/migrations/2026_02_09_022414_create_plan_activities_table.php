<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plan_activities', function (Blueprint $table) {
            $table->id();
            $table->string('cabang');
            $table->enum('jenis_activity', ['Offline', 'Online']);
            $table->enum('activity', ['D_MARKETING', 'EXHIBITION', 'MOVING_EXHIBITION', 'SHOWROOM_EVENT', 'GROUP_PRESENTATION', 'EVENT_TEST_DRIVE', 'OPEN_TABLE', 'CETAK_FLYER']);
            $table->string('platform_lokasi');
            $table->enum('jenis_unit', ['Commercial', 'Passenger']);
            $table->enum('type_unit', ['CARRY_PU', 'CARRY_BOX', 'CARRY_BV', 'CARRY_MOKO', 'CARRY_AMBULANCE', 'CARRY_TOWING', 'APV_MB', 'APV_AMBULANCE', 'ERTIGA', 'ERTIGA_HYBRID', 'XL7', 'XL7_HYBRID', 'S_PRESSO', 'IGNIS', 'e_VITARA', 'GRAND_VITARA', 'JIMNY']);
            $table->date('tanggal');
            $table->time('jam');
            $table->string('pic');
            $table->string('jml_sales_shift');
            $table->integer('target_p')->default(0);
            $table->integer('target_hp')->default(0);
            $table->integer('target_spk')->default(0);
            $table->integer('actual_p')->default(0);
            $table->integer('actual_hp')->default(0);
            $table->integer('actual_spk')->default(0);
            $table->integer('actual_do')->default(0);
            $table->decimal('total_cost', 15, 2)->default(0);
            $table->decimal('cost_p', 15, 2)->default(0);
            $table->decimal('cost_spk', 15, 2)->default(0);
            $table->decimal('cost_do', 15, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('plan_activities');
    }
};
