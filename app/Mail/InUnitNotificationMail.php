<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InUnitExport;

class InUnitNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $inUnits;

    /**
     * Create a new message instance.
     */
    public function __construct($inUnits)
    {
        $this->inUnits = $inUnits;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(env('MAIL_STOCK_FROM_ADDRESS', 'no-reply@suzukidutacendana.com'), env('MAIL_STOCK_FROM_NAME', 'Suzuki Duta Cendana')),
            subject: 'Notifikasi Data In Unit Hari Ini',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.in_unit_notification',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        // Generate Excel (.xlsx) from the InUnit collection
        try {
            $excelData = Excel::raw(new InUnitExport($this->inUnits), \Maatwebsite\Excel\Excel::XLSX);

            return [
                Attachment::fromData(
                    fn () => $excelData,
                    'Laporan_Data_In_Unit.xlsx'
                )->withMime('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'),
            ];
        } catch (\Throwable $e) {
            // Fallback to PDF if Excel generation fails
            $pdf = Pdf::loadView(
                'pdf.in_unit_download',
                ['inUnits' => $this->inUnits]
            )->setPaper('a4', 'landscape');

            return [
                Attachment::fromData(
                    fn () => $pdf->output(),
                    'Laporan_Data_In_Unit.pdf'
                )->withMime('application/pdf'),
            ];
        }
    }
}
