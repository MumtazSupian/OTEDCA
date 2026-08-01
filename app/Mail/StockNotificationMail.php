<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Mail\Mailables\Address;

class StockNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $stocks;
    public $withPrices;
    public $dashboardData;
    public $subject;

    /**
     * Create a new message instance.
     */
    public function __construct($stocks, $withPrices = false, $dashboardData = null)
    {
        $this->stocks = $stocks;
        $this->withPrices = $withPrices;
        $this->dashboardData = $dashboardData;
        // Determine subject based on whether price is included
        $this->subject = $withPrices ? 'Notifikasi Stock' : 'Notifikasi Stock Free Matching';
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(env('MAIL_STOCK_FROM_ADDRESS', 'no-reply@arunit.com'), env('MAIL_STOCK_FROM_NAME', 'ArUnit')),
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.stock_notification',
            // kirim data ke view
            with: [
                'stocks' => $this->stocks,
                'withPrices' => $this->withPrices,
                'dashboardData' => $this->dashboardData,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        $pdf = Pdf::loadView(
            'pdf.stock_download',
            ['stocks' => $this->stocks, 'withPrices' => $this->withPrices]
        )->setPaper('a4', 'landscape');

        $attachments = [
            Attachment::fromData(
                fn () => $pdf->output(),
                'Laporan_Stock.pdf'
            )->withMime('application/pdf'),
        ];

        // Attach Excel for penerimaTanpaHarga as requested
        if (!$this->withPrices) {
            $excelData = \Maatwebsite\Excel\Facades\Excel::raw(
                new \App\Exports\StockEmailExport($this->stocks), 
                \Maatwebsite\Excel\Excel::XLSX
            );

            $attachments[] = Attachment::fromData(
                fn () => $excelData,
                'Laporan_Stock.xlsx'
            )->withMime('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        }

        return $attachments;
    }
}
