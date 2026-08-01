<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class WeeklyBranchDataMail extends Mailable
{
    use Queueable, SerializesModels;

    public $branchData;
    public $tipePenerima;
    public function __construct($branchData, $tipePenerima = 'Global')
    {
        $this->branchData = $branchData;
        $this->tipePenerima = $tipePenerima;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Weekly Branch Data Mail - ' . $this->tipePenerima,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.branch_data_weekly',
        );
    }

    public function attachments(): array
    {
        $pdf = Pdf::loadView(
            'pdf.branch_data_weekly',
            ['branchData' => $this->branchData]
        )
        ->setPaper('a4', 'landscape');

        $namaFilePdf = 'Laporan_Mingguan_' . str_replace(' ', '_', $this->tipePenerima) . '.pdf';

        return [
            Attachment::fromData(
                fn () => $pdf->output(),
                $namaFilePdf
            )->withMime('application/pdf'),
        ];
    }
}