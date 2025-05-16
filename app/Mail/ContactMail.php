<?php

namespace App\Mail;

use App\Traits\MailSettingsTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels,MailSettingsTrait;

    /**
     * Create a new message instance.
     */
    public array $user = [];
    public string $logo;
    public string $privacy_url = 'https://cqdcleaningservices.com';
    public mixed $settings;
    public function __construct(array $user)
    {
        $this->user = $user;
        $this->settings = $this->getSettings();
        $this->logo = $this->getLogo($this->settings);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Contact Request Received',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.contact',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
