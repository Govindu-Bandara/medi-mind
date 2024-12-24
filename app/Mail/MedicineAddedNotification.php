<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MedicineAddedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $medicine;

    /**
     * Create a new message instance.
     */
    public function __construct($medicine)
    {
        $this->medicine = $medicine;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Medicine Added to Medi Mind'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.medicine_added', // Reference the Blade template for the email content
            with: [
                'medicineName' => $this->medicine->name,
                'dosage' => $this->medicine->dosage,
                'times' => $this->medicine->times,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
