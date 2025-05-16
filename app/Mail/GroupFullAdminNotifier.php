<?php

namespace App\Mail;

use App\Models\Customer;
use App\Models\Group;
use App\Models\Package;
use App\Traits\MailSettingsTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GroupFullAdminNotifier extends Mailable
{
    use Queueable, SerializesModels,MailSettingsTrait;

    public ?Package $package;
    public ?Group $group;
    public  $customers;
    public string $privacy_url = 'https://cqdcleaningservices.com';
    public mixed $settings;
    public function __construct(Package $package, Group $group)
    {
        $this->package = $package;
        $this->group = $group;
        $this->customers = $group->members ?? [];
        $this->settings = $this->getSettings();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Service Group Complete: {$this->package->title} Ready to Start",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.group-full-notify-for-admin',
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
