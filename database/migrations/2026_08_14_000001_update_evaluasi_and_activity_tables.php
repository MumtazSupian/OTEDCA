<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Update evaluasi_wiraniaga table with jul-des and user_id
        if (Schema::connection('mysql')->hasTable('evaluasi_wiraniaga')) {
            Schema::connection('mysql')->table('evaluasi_wiraniaga', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('evaluasi_wiraniaga', 'jul')) {
                    $table->integer('jul')->default(0)->after('jun');
                }
                if (!Schema::connection('mysql')->hasColumn('evaluasi_wiraniaga', 'agu')) {
                    $table->integer('agu')->default(0)->after('jul');
                }
                if (!Schema::connection('mysql')->hasColumn('evaluasi_wiraniaga', 'sep')) {
                    $table->integer('sep')->default(0)->after('agu');
                }
                if (!Schema::connection('mysql')->hasColumn('evaluasi_wiraniaga', 'okt')) {
                    $table->integer('okt')->default(0)->after('sep');
                }
                if (!Schema::connection('mysql')->hasColumn('evaluasi_wiraniaga', 'nov')) {
                    $table->integer('nov')->default(0)->after('okt');
                }
                if (!Schema::connection('mysql')->hasColumn('evaluasi_wiraniaga', 'des')) {
                    $table->integer('des')->default(0)->after('nov');
                }
                if (!Schema::connection('mysql')->hasColumn('evaluasi_wiraniaga', 'user_id')) {
                    $table->unsignedBigInteger('user_id')->nullable()->after('cabang');
                }
            });
        }

        // 2. Update type_unit enum and add user_id in plan_activities and actual_activities
        $enums = "'CARRY_PU','CARRY_BOX','CARRY_BV','CARRY_MOKO','CARRY_AMBULANCE','CARRY_TOWING','APV_MB','APV_AMBULANCE','ERTIGA','ERTIGA_HYBRID','XL7','XL7_HYBRID','S_PRESSO','IGNIS','e_VITARA','GRAND_VITARA','JIMNY','FRONX'";

        if (Schema::connection('mysql')->hasTable('plan_activities')) {
            DB::connection('mysql')->statement("ALTER TABLE `plan_activities` MODIFY COLUMN `type_unit` ENUM($enums) NOT NULL");
            if (!Schema::connection('mysql')->hasColumn('plan_activities', 'user_id')) {
                Schema::connection('mysql')->table('plan_activities', function (Blueprint $table) {
                    $table->unsignedBigInteger('user_id')->nullable()->after('cabang');
                });
            }
        }

        if (Schema::connection('mysql')->hasTable('actual_activities')) {
            DB::connection('mysql')->statement("ALTER TABLE `actual_activities` MODIFY COLUMN `type_unit` ENUM($enums) NOT NULL");
            if (!Schema::connection('mysql')->hasColumn('actual_activities', 'user_id')) {
                Schema::connection('mysql')->table('actual_activities', function (Blueprint $table) {
                    $table->unsignedBigInteger('user_id')->nullable()->after('cabang');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::connection('mysql')->hasTable('evaluasi_wiraniaga')) {
            Schema::connection('mysql')->table('evaluasi_wiraniaga', function (Blueprint $table) {
                $columns = ['jul', 'agu', 'sep', 'okt', 'nov', 'des', 'user_id'];
                foreach ($columns as $col) {
                    if (Schema::connection('mysql')->hasColumn('evaluasi_wiraniaga', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }

        if (Schema::connection('mysql')->hasTable('plan_activities')) {
            if (Schema::connection('mysql')->hasColumn('plan_activities', 'user_id')) {
                Schema::connection('mysql')->table('plan_activities', function (Blueprint $table) {
                    $table->dropColumn('user_id');
                });
            }
        }

        if (Schema::connection('mysql')->hasTable('actual_activities')) {
            if (Schema::connection('mysql')->hasColumn('actual_activities', 'user_id')) {
                Schema::connection('mysql')->table('actual_activities', function (Blueprint $table) {
                    $table->dropColumn('user_id');
                });
            }
        }
    }
};
