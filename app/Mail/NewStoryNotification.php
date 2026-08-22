<?php

namespace App\Mail;

use App\Models\Testimonial;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewStoryNotification extends Mailable
{
    use Queueable, SerializesModels;

    public Testimonial $testimonial;

    /**
     * Create a new message instance.
     */
    public function __construct(Testimonial $testimonial)
    {
        $this->testimonial = $testimonial;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $author = $this->testimonial->name ?? 'Traveller';
        $ratingStars = str_repeat('★', (int)($this->testimonial->rating ?? 5));

        return new Envelope(
            from: new Address(config('mail.from.address'), 'Worldine Destinations (Do Not Reply)'),
            replyTo: [
                new Address('no-reply@worldinedestinations.com', 'Do Not Reply'),
            ],
            subject: "[New Traveller Story] {$ratingStars} - {$author}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.new_story',
            with: [
                'testimonial' => $this->testimonial,
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
