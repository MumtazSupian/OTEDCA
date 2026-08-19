<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Piutang;
use App\Mail\WeeklyBranchDataMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendWeeklyBranchDataEmail extends Command
{
    protected $signature = 'app:send-weekly-branch-data-email';
    protected $description = 'Send weekly branch data via email to branches and admin';

    public function handle()
    {
        // ini_set('memory_limit', '1024M');
        ini_set('memory_limit', '-1');
        
        $this->info('Mulai memproses data piutang mingguan...');

        $dataMingguan = Piutang::with('perusahaan')
            ->where(function ($query) {

                $query->where('piutangs.created_at', '>=', Carbon::now('Asia/Jakarta')->subDays(7));

                $query->orWhere(function ($q) {
                    $q->where('piutangs.spk_type', 'REGULER')
                    ->whereDate('piutangs.tgl_bukti', '<=', Carbon::now('Asia/Jakarta')->subDays(7));
                });

                $query->orWhere(function ($q) {
                    $q->where('piutangs.spk_type', 'ASURANSI')
                    ->whereDate('piutangs.tgl_bukti', '<=', Carbon::now('Asia/Jakarta')->subDays(35));
                });

                $query->orWhere(function ($q) {
                    $q->where('piutangs.tipe_konsumen', 'perusahaan');
                });

            })
            ->where('saldo_akhir', '>', 0)
            ->get();

            $dataMingguan = $dataMingguan->filter(function ($item) {

            $isNew = Carbon::parse($item->created_at, 'Asia/Jakarta')->diffInDays(Carbon::now('Asia/Jakarta')) <= 7;
            if ($isNew) {
                return true;
            }

            if (strtolower($item->tipe_konsumen) !== 'perusahaan') {
                return true;
            }

            $overdue = optional($item->perusahaan)->overdue ?? 28;

            $umurPiutang = Carbon::parse($item->tgl_bukti, 'Asia/Jakarta')
                ->diffInDays(Carbon::now('Asia/Jakarta'));

            return $umurPiutang >= $overdue;
        });

        if ($dataMingguan->isEmpty()) {
            $this->info('Tidak ada data piutang baru atau tagihan menunggak minggu ini.');
            return;
        }

        $branchDataGrouped = $dataMingguan->groupBy(function($item) {
            $namaBranch = strtoupper(trim($item->branch));

            if (str_contains($namaBranch, 'CIAWI')) return 'Ciawi';
            if (str_contains($namaBranch, 'CINERE')) return 'Cinere';
            if (str_contains($namaBranch, 'CIANJUR')) return 'Cianjur';
            if (str_contains($namaBranch, 'JATIASIH')) return 'Jatiasih';
            if (str_contains($namaBranch, 'BP')) return 'BP';

            return 'Tidak Diketahui';
        });

        $daftarEmailCabang = [
            'Ciawi' => [
                'sender' => 'adh.cwi@suzukidutacendana.com',
                'password' => 'xzuogjornldtedra', 
                'recipients' => [
                    'admsvc.cwi.dca@gmail.com',
                    'sm.cwi.dca@gmail.com',
                    'adh.cwi@suzukidutacendana.com',
                    'bm.cwi@suzukidutacendana.com',
                    'heru.dca2023@gmail.com'
                ]
            ],
            'Cianjur' => [
                'sender' => 'adh.cjr@suzukidutacendana.com',
                'password' => 'lghzhfbkavsuwwxi',
                'recipients' => [
                    'admsvc.cjr.dca@gmail.com',
                    'adh.cjr@suzukidutacendana.com',
                    'bm.cjr@suzukidutacendana.com',
                    'sm.cjr.dca@gmail.com'
                ]
            ],
            'Cinere' => [
                'sender' => 'adh.cnr@suzukidutacendana.com', 
                // 'password' => 'lxupzvinvkxvjlxr', // Dimatikan sementara agar pakai akun AR
                'recipients' => [
                    'adh.cnr@suzukidutacendana.com',
                    'admsvc.cnr.dca@gmail.com',
                    'sm.cnr.dca@gmail.com',
                    'bm.cnr@suzukidutacendana.com',
                ]
            ],
            'Jatiasih' => [
                'sender' => 'adh.jts@suzukidutacendana.com',
                'password' => 'jgaobrfuqkeollam',
                'recipients' => [
                    'adh.jts@suzukidutacendana.com',
                    'admsvc.jts.dca@gmail.com',
                    'sm.jts.dca@gmail.com',
                    'bm.jts@suzukidutacendana.com',
                ]
            ],
            'BP' => [
                'sender' => 'adh.jts@suzukidutacendana.com', 
                'password' => 'jgaobrfuqkeollam',
                'recipients' => [
                    'adh.jts@suzukidutacendana.com',
                    'bp.dca@suzukidutacendana.com',
                    'admbp.dcajts@gmail.com',
                    'bm.jts@suzukidutacendana.com',
                ]
            ],
        ];

        $emailAdminPusat = [
            'vwilliam@dutacendana.com',
            'som.dca@gmail.com',
            'accspv@dutacendana.com',
            'it@dutacendana.com',
            'finance@suzukidutacendana.com',
            'fineke99@gmail.com',
            'om@suzukidutacendana.com'
        ];
        
        foreach ($daftarEmailCabang as $namaCabang => $konfigurasi) {
            $senderEmail = $konfigurasi['sender'] ?? null;
            $senderPassword = $konfigurasi['password'] ?? null;
            $paraPenerima = $konfigurasi['recipients'] ?? [];

            $dataKhususCabang = $branchDataGrouped->get($namaCabang);

            if (!empty($paraPenerima) && $dataKhususCabang && $dataKhususCabang->isNotEmpty()) {
                $this->info("Mengirim email rekap ke Cabang: {$namaCabang}...");

                $sendToBranchData = collect([$namaCabang => $dataKhususCabang]);
                $mailable = new WeeklyBranchDataMail($sendToBranchData, "Cabang {$namaCabang}", $senderEmail);

                // Menggunakan login SMTP khusus untuk cabang jika password tersedia
                if ($senderEmail && $senderPassword) {
                    $mailer = Mail::build([
                        'transport' => 'smtp',
                        'host' => config('mail.mailers.smtp.host'),
                        'port' => config('mail.mailers.smtp.port'),
                        'encryption' => config('mail.mailers.smtp.encryption'),
                        'username' => $senderEmail,
                        'password' => $senderPassword,
                    ]);
                    // $mailer->to($paraPenerima)->send($mailable);
                    $mailer->to($paraPenerima)->cc($emailAdminPusat)->send($mailable);
                } else {
                    // Mail::to($paraPenerima)->send($mailable);
                    Mail::to($paraPenerima)->cc($emailAdminPusat)->send($mailable);
                }
            }
        }

        // $this->info('Mengirim email rekap ALL CABANG ke jajaran Admin Pusat...');
        // Mail::to($emailAdminPusat)->send(new WeeklyBranchDataMail($branchDataGrouped, "Kombinasi Semua Cabang"));

        $this->info('Seluruh rangkaian pengiriman email mingguan sukses dilakukan!');
    }
}
