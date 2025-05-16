<?php

namespace App\Mail;

use App\Models\Customer;
use App\Models\Package;
use App\Traits\MailSettingsTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GroupFullMail extends Mailable
{
    use Queueable, SerializesModels,MailSettingsTrait;

    public Package $package;
    public Customer $customer;
    public string $logo;
    public string $privacy_url = 'https://cqdcleaningservices.com';
    public mixed $settings;
    public function __construct(Package $package, Customer $customer)
    {
        $this->package = $package;
        $this->customer = $customer;
        $this->settings = $this->getSettings();
        $this->logo = $this->getLogo($this->settings);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "The {$this->package->title} Package Group is Full",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.group-full',
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
