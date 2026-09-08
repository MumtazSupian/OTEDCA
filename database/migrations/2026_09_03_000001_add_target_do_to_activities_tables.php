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
        if (Schema::connection('mysql')->hasTable('plan_activities')) {
            // Ubah type_unit, activity, jam agar flexible dan tidak error strict mode
            DB::connection('mysql')->statement("ALTER TABLE `plan_activities` MODIFY COLUMN `type_unit` VARCHAR(255) NULL");
            DB::connection('mysql')->statement("ALTER TABLE `plan_activities` MODIFY COLUMN `activity` VARCHAR(255) NULL");
            DB::connection('mysql')->statement("ALTER TABLE `plan_activities` MODIFY COLUMN `jenis_activity` VARCHAR(255) NULL");
            DB::connection('mysql')->statement("ALTER TABLE `plan_activities` MODIFY COLUMN `jenis_unit` VARCHAR(255) NULL");
            DB::connection('mysql')->statement("ALTER TABLE `plan_activities` MODIFY COLUMN `jam` TIME NULL DEFAULT '00:00:00'");

            Schema::connection('mysql')->table('plan_activities', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('plan_activities', 'target_do')) {
                    $table->integer('target_do')->default(0)->after('target_spk');
                }
            });
        }

        if (Schema::connection('mysql')->hasTable('actual_activities')) {
            // Ubah type_unit, activity, jam agar flexible dan tidak error strict mode
            DB::connection('mysql')->statement("ALTER TABLE `actual_activities` MODIFY COLUMN `type_unit` VARCHAR(255) NULL");
            DB::connection('mysql')->statement("ALTER TABLE `actual_activities` MODIFY COLUMN `activity` VARCHAR(255) NULL");
            DB::connection('mysql')->statement("ALTER TABLE `actual_activities` MODIFY COLUMN `jenis_activity` VARCHAR(255) NULL");
            DB::connection('mysql')->statement("ALTER TABLE `actual_activities` MODIFY COLUMN `jenis_unit` VARCHAR(255) NULL");
            DB::connection('mysql')->statement("ALTER TABLE `actual_activities` MODIFY COLUMN `jam` TIME NULL DEFAULT '00:00:00'");

            Schema::connection('mysql')->table('actual_activities', function (Blueprint $table) {
                if (!Schema::connection('mysql')->hasColumn('actual_activities', 'target_do')) {
                    $table->integer('target_do')->default(0)->after('target_spk');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::connection('mysql')->hasTable('plan_activities')) {
            Schema::connection('mysql')->table('plan_activities', function (Blueprint $table) {
                if (Schema::connection('mysql')->hasColumn('plan_activities', 'target_do')) {
                    $table->dropColumn('target_do');
                }
            });
        }

        if (Schema::connection('mysql')->hasTable('actual_activities')) {
            Schema::connection('mysql')->table('actual_activities', function (Blueprint $table) {
                if (Schema::connection('mysql')->hasColumn('actual_activities', 'target_do')) {
                    $table->dropColumn('target_do');
                }
            });
        }
    }
};
