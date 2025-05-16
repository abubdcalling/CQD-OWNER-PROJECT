<?php

namespace App\Mail;

use App\Models\Customer;
use App\Traits\MailSettingsTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class GroupMemberMail extends Mailable
{
    use Queueable, SerializesModels,MailSettingsTrait;

    /**
     * Create a new message instance.
     */
    public string $mail_subject;
    public string $content;
    public Customer $user;
    public mixed $settings;
    public string $privacy_url = 'https://cqdcleaningservices.com';
    public string $logo;
    public function __construct(string $subject, string $message, Customer $user)
    {
        $this->mail_subject = $subject;
        $this->content = $message;
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
            subject: $this->mail_subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.group-member-mail',
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
