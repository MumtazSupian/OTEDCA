<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\InUnit;
use App\Mail\InUnitNotificationMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendInUnitEmailCommand extends Command
{
    protected $signature = 'app:send-in-unit-email';
    protected $description = 'Send email for InUnit data created or updated on the previous day to specific recipients';

    public function handle()
    {
        $this->info('Mulai mengecek data InUnit kemarin...');

        $penerima = [
            'it@dutacendana.com',
            'adh.cwi@suzukidutacendana.com',
            'adh.cjr@suzukidutacendana.com',
            'adh.cnr@suzukidutacendana.com',
            'adh.jts@suzukidutacendana.com',
            'hrd@suzukidutacendana.com',
            'stock@suzukidutacendana.com'
        ];

        $inUnits = InUnit::all();

        if ($inUnits->isEmpty()) {
            $this->info('Tidak ada data InUnit di tabel.');
            return;
        }

        Mail::mailer('smtp_stock')
            ->to($penerima)
            ->send(new InUnitNotificationMail($inUnits));

        $this->info("Email InUnit sukses dikirim (Total: {$inUnits->count()} unit). ");
        $this->info('Selesai memproses email InUnit.');
    }
}
