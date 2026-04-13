<?php

namespace App\Mail;

use App\Models\Peserta;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CompetitionPaymentStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Peserta $peserta,
        public string $stage,
        public string $status,
        public ?string $groupLink = null,
        public ?string $rejectionReason = null,
    ) {
    }

    public function envelope(): Envelope
    {
        $stageLabel = ucfirst($this->stage);
        $statusLabel = $this->status === 'verified' ? 'Verified' : 'Rejected';

        return new Envelope(
            from: new Address('inceptionundip@gmail.com', 'Inception 2026'),
            subject: "{$stageLabel} Payment {$statusLabel} - Inception 2026",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.competition-payment-status',
            with: [
                'teamName' => $this->peserta->nama_tim,
                'leaderName' => $this->peserta->nama_leader,
                'university' => $this->peserta->asal_univ,
                'categoryName' => config("competitions.categories.{$this->peserta->kategori}.name", 'Competition'),
                'stageLabel' => ucfirst($this->stage),
                'isVerified' => $this->status === 'verified',
                'groupLink' => $this->groupLink,
                'rejectionReason' => $this->rejectionReason,
                'isDummyLink' => is_string($this->groupLink) && str_contains($this->groupLink, 'CHANGE_ME'),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}