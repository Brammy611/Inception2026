<?php

namespace App\Mail;

use App\Models\CareerTalkRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class CareerTalkConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $registration;

    /**
     * Create a new message instance.
     */
    public function __construct(CareerTalkRegistration $registration)
    {
        $this->registration = $registration;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('noreply@inception2026.com', 'Inception 2026'),
            subject: 'Konfirmasi Registrasi Career Talk - Inception 2026',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.career-talk-confirmation',
            with: [
                'registrationNumber' => $this->registration->registration_number,
                'fullName' => $this->registration->full_name,
                'email' => $this->registration->email,
                'phone' => $this->registration->phone,
                'institution' => $this->registration->institution,
                'major' => $this->registration->major,
                'semester' => $this->registration->semester,
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