<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pmMstPlanSales', function (Blueprint $table) {
            $table->id(); 
            $table->string('CompanyCode', 15)->nullable();
            $table->string('BranchCode', 15)->nullable();
            $table->string('SpvEmployeeID', 50)->nullable();
            $table->string('SourceCode', 50)->nullable();
            $table->string('DetailCode', 50)->nullable();
            
            //diisi nama Salesman / nama Tipe Mobil / nama Aktivitas SOI
            $table->string('DetailName', 100)->nullable();
            
            $table->integer('Year')->nullable();
            $table->integer('Month')->nullable();
            
            //Diisi 'BySalesman', 'ByType', atau 'ByActivity'
            $table->string('SourceName', 50)->default('BySalesman');

            // Target Week 1 sampai Week 5 (DO, SPK, INQ)
            $table->integer('DO_Week1')->default(0);
            $table->integer('SPK_Week1')->default(0);
            $table->integer('INQ_Week1')->default(0);

            $table->integer('DO_Week2')->default(0);
            $table->integer('SPK_Week2')->default(0);
            $table->integer('INQ_Week2')->default(0);

            $table->integer('DO_Week3')->default(0);
            $table->integer('SPK_Week3')->default(0);
            $table->integer('INQ_Week3')->default(0);

            $table->integer('DO_Week4')->default(0);
            $table->integer('SPK_Week4')->default(0);
            $table->integer('INQ_Week4')->default(0);

            $table->integer('DO_Week5')->default(0);
            $table->integer('SPK_Week5')->default(0);
            $table->integer('INQ_Week5')->default(0);

            // Audit Trail
            $table->string('CreatedBy', 50)->nullable();
            $table->dateTime('CreatedDate')->nullable();
            $table->string('UpdatedBy', 50)->nullable();
            $table->dateTime('UpdatedDate')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pmMstPlanSales');
    }
};