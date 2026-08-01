<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('piutangs', function (Blueprint $table) {
            if (! Schema::hasColumn('piutangs', 'tgl_bukti_rek_2')) {
                $table->date('tgl_bukti_rek_2')->nullable()->after('keterangan');
            }
            if (! Schema::hasColumn('piutangs', 'no_bukti_rek_2')) {
                $table->string('no_bukti_rek_2')->nullable()->after('tgl_bukti_rek_2');
            }
            if (! Schema::hasColumn('piutangs', 'keterangan_2')) {
                $table->string('keterangan_2')->nullable()->after('no_bukti_rek_2');
            }
            if (! Schema::hasColumn('piutangs', 'tgl_bukti_rek_3')) {
                $table->date('tgl_bukti_rek_3')->nullable()->after('keterangan_2');
            }
            if (! Schema::hasColumn('piutangs', 'no_bukti_rek_3')) {
                $table->string('no_bukti_rek_3')->nullable()->after('tgl_bukti_rek_3');
            }
            if (! Schema::hasColumn('piutangs', 'keterangan_3')) {
                $table->string('keterangan_3')->nullable()->after('no_bukti_rek_3');
            }
        });
    }

    public function down(): void
    {
        Schema::table('piutangs', function (Blueprint $table) {
            $table->dropColumn([
                'tgl_bukti_rek_2',
                'no_bukti_rek_2',
                'keterangan_2',
                'tgl_bukti_rek_3',
                'no_bukti_rek_3',
                'keterangan_3',
            ]);
        });
    }
};
