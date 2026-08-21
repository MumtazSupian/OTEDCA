<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pre_check_acs', function (Blueprint $table) {
            $table->string('no_spk')->nullable()->after('jenis_pemeriksaan');
        });
        Schema::table('post_check_acs', function (Blueprint $table) {
            $table->string('no_spk')->nullable()->after('jenis_pemeriksaan');
        });
    }

    public function down()
    {
        Schema::table('pre_check_acs', function (Blueprint $table) {
            $table->dropColumn('no_spk');
        });
        Schema::table('post_check_acs', function (Blueprint $table) {
            $table->dropColumn('no_spk');
        });
    }
};
