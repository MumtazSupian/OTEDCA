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
         Schema::create('evaluasi_wiraniaga', function (Blueprint $table) {
        $table->id();
        $table->string('nama_sales_head');
        $table->string('nama_sales');
        $table->date('tanggal_masuk')->nullable();
        $table->date('tanggal_evaluasi')->nullable();
        $table->string('grading')->nullable();

        $table->integer('jan')->default(0);
        $table->integer('feb')->default(0);
        $table->integer('mar')->default(0);
        $table->integer('apr')->default(0);
        $table->integer('mei')->default(0);
        $table->integer('jun')->default(0);
        $table->integer('jul')->default(0);
        $table->integer('agu')->default(0);
        $table->integer('sep')->default(0);
        $table->integer('okt')->default(0);
        $table->integer('nov')->default(0);
        $table->integer('des')->default(0);

        $table->integer('total')->default(0);
        $table->text('evaluasi')->nullable();
        $table->date('tanggal_keluar')->nullable();

        $table->string('cabang');
        $table->unsignedBigInteger('user_id')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluasi_wiraniagas');
    }
};
