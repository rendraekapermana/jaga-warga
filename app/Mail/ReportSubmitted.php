<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class ReportSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $reportData;

    public function __construct(array $reportData)
    {
        $this->reportData = $reportData;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Laporan Baru: ' . $this->reportData['incident_type'],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.report-submitted',
        );
    }

    public function attachments(): array
    {
        if (isset($this->reportData['evidence_file_path'])) {
            return [
                Attachment::fromPath(storage_path('app/' . $this->reportData['evidence_file_path']))
                    ->as($this->reportData['evidence_file_name'])
            ];
        }
        
        return [];
    }
}