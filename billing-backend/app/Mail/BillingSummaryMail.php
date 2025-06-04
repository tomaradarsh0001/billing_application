<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BillingSummaryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $pdfContent;
    public $fileName;

    public function __construct($data, $pdfContent, $fileName)
    {
        $this->data = $data;
        $this->pdfContent = $pdfContent;
        $this->fileName = $fileName;
    }

    public function build()
    {
        return $this->subject('Your Billing Summary')
            ->markdown('emails.billing_summary')
            ->attachData($this->pdfContent, $this->fileName, [
                'mime' => 'application/pdf',
            ])
            ->with('data', $this->data);
    }
}
