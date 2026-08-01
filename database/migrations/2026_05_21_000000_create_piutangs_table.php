<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('piutangs', function (Blueprint $table) {
            $table->id();
            $table->string('branch');
            $table->string('tipe_konsumen')->nullable();
            $table->unsignedBigInteger('perusahaan_id')->nullable();
            $table->string('nama_konsumen')->nullable();
            $table->date('tgl_bukti')->nullable();
            $table->string('no_bukti')->nullable();

            $table->decimal('saldo_awal', 20, 2)->default(0);
            $table->decimal('debet', 20, 2)->default(0);

            $table->decimal('kredit', 20, 2)->default(0);
            $table->decimal('kredit_2', 20, 2)->default(0); 
            $table->decimal('kredit_3', 20, 2)->default(0); 

            $table->date('tgl_bukti_rek')->nullable();
            $table->string('no_bukti_rek')->nullable();

            $table->decimal('saldo_akhir', 20, 2)->default(0);

            $table->string('keterangan')->nullable();
            $table->string('no_polisi')->nullable();
            $table->string('no_polis')->nullable();
            $table->string('spk_type')->nullable();
            $table->string('no_spk')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('piutangs');
    }
};
