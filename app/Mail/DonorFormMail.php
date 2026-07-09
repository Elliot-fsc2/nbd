<?php

namespace App\Mail;

use App\Models\Donor;
use App\Services\PdfGenerationService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class DonorFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public Donor $donor;

    public function __construct(public Donor $donorData)
    {
        $this->donor = $donorData;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Blood Donation Form',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.donor-form',
        );
    }

    /** @return array<int, Attachment> */
    public function attachments(): array
    {
        $pdf = app(PdfGenerationService::class)->generate($this->donor);

        return [
            Attachment::fromData(fn () => $pdf, 'donation-form-'.Str::slug($this->donor->full_name).'.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
