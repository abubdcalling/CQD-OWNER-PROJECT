<?php

namespace App\Mail;

use App\Models\Customer;
use App\Models\Package;
use App\Traits\MailSettingsTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReminderMail extends Mailable
{
    use Queueable, SerializesModels,MailSettingsTrait;

    public Package $package;
    public Customer $customer;
    public string $logo;
    public string $privacy_url = 'https://cqdcleaningservices.com';
    public mixed $settings;
    public string $client_id;
    public function __construct(Package $package, $client_id)
    {
        $this->package = $package;
        $this->settings = $this->getSettings();
        $this->logo = $this->getLogo($this->settings);
        $this->client_id = $client_id;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Don’t Wait! Finish Your '.$this->package->title.' Application and Get Started',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.reminder',
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
