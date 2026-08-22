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
        $customer = $this->inquiry->customer_name ?? 'Guest';
        
        if ($this->inquiry->type === 'package_inquiry') {
            $pkg = $this->inquiry->package_title ?: 'Tour Package';
            $subject = "Tour Booking Inquiry | {$pkg} - {$customer}";
        } else {
            $category = $this->inquiry->inquiry_type ?: ($this->inquiry->destination_name ?: 'General Inquiry');
            $subject = "Contact Inquiry | {$category} - {$customer}";
        }

        $replyToList = [];
        if (!empty($this->inquiry->email) && filter_var($this->inquiry->email, FILTER_VALIDATE_EMAIL)) {
            $replyToList[] = new Address($this->inquiry->email, $customer);
        }

        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name', 'Worldine Destinations')),
            replyTo: $replyToList,
            subject: $subject,
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
