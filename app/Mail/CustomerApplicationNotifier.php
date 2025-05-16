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

class CustomerApplicationNotifier extends Mailable
{
    use Queueable, SerializesModels,MailSettingsTrait;

    /**
     * Create a new message instance.
     */

    public Package $package;
    public Customer $customer;
    public string $privacy_url = 'https://cqdcleaningservices.com';
    public mixed $settings;
    public int $current_group_size = 0;
    public string $application_date = "";
    public function __construct(Package $package, Customer $customer,$current_group_size,$application_date)
    {
        $this->package = $package;
        $this->customer = $customer;
        $this->settings = $this->getSettings();
        $this->current_group_size = $current_group_size;
        $this->application_date = $application_date;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Cleaning Service Application Received - '.$this->package->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.applicaion-notify-for-admin',
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
