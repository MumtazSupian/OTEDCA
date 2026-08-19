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
    public $senderEmail;
    public function __construct($branchData, $tipePenerima = 'Global', $senderEmail = null)
    {
        $this->branchData = $branchData;
        $this->tipePenerima = $tipePenerima;
        $this->senderEmail = $senderEmail;
    }

    public function envelope(): Envelope
    {
        $envelopeArgs = [
            'subject' => 'Weekly Branch Data Mail - ' . $this->tipePenerima,
        ];

        if ($this->senderEmail) {
            $envelopeArgs['from'] = new \Illuminate\Mail\Mailables\Address($this->senderEmail, 'Admin ' . $this->tipePenerima);
        }

        return new Envelope(...$envelopeArgs);
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