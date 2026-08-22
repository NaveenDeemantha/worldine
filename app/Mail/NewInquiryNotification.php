<?php

namespace App\Mail;

use App\Models\Inquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewInquiryNotification extends Mailable
{
    use Queueable, SerializesModels;

    public Inquiry $inquiry;

    /**
     * Create a new message instance.
     */
    public function __construct(Inquiry $inquiry)
    {
        $this->inquiry = $inquiry;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $typeLabel = $this->inquiry->type === 'package_inquiry' ? 'New Booking Inquiry' : 'New Contact Lead';
        $ref = $this->inquiry->reference_id ?? 'WRD';
        $customer = $this->inquiry->customer_name ?? 'Guest';

        return new Envelope(
            from: new Address(config('mail.from.address'), 'Worldine Destinations (Do Not Reply)'),
            replyTo: [
                new Address('no-reply@worldinedestinations.com', 'Do Not Reply'),
            ],
            subject: "[{$typeLabel}] {$ref} - {$customer}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.new_inquiry',
            with: [
                'inquiry' => $this->inquiry,
            ],
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
