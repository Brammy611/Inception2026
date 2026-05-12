<?php

namespace App\Mail;

use App\Models\Peserta;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class PesertaVerifiedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $peserta;
    public $whatsappLink;
    public $categoryName;

    /**
     * Create a new message instance.
     */
    public function __construct(Peserta $peserta)
    {
        $this->peserta = $peserta;
        
        // Define WhatsApp group links for each category
        $whatsappLinks = [
            'business_case' => 'https://chat.whatsapp.com/EuwgY264bBr9orvok8zR0Q',
            'poster_paper' => 'https://chat.whatsapp.com/KHIoF9oTpovE93DwBfTI0S',
            'geothermal' => 'https://chat.whatsapp.com/DzZM4FROfVaBvyvDEnrJ0D',
            'well_stimulation' => 'https://chat.whatsapp.com/LnUZsICvMQ2JG0qyokwTxN',
        ];

        $categoryNames = [
            'business_case' => 'Business Case Competition',
            'poster_paper' => 'Petroleum Paper Competition',
            'geothermal' => 'Geothermal Drilling Paper Competition',
            'well_stimulation' => 'Well Stimulation Competition',
        ];

        $this->whatsappLink = $whatsappLinks[$peserta->kategori] ?? '#';
        $this->categoryName = $categoryNames[$peserta->kategori] ?? 'Competition';
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('inceptionundip@gmail.com', 'Inception 2026'),
            subject: 'Selamat! Pendaftaran Anda Telah Diverifikasi - Inception 2026',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.peserta-verified',
            with: [
                'teamName' => $this->peserta->nama_tim,
                'leaderName' => $this->peserta->nama_leader,
                'university' => $this->peserta->asal_univ,
                'category' => $this->categoryName,
                'whatsappLink' => $this->whatsappLink,
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
