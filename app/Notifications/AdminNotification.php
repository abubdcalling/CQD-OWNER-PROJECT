<?php

namespace App\Notifications;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminNotification extends Notification
{
    use Queueable;

    public string $message;
    public Customer | Collection $user;
    public string $type;
    public array $data;
    public string $package_name;
    /**
     * Create a new notification instance.
     */
    public function __construct(string $message, Customer | Collection $user, string $type,$package_name)
    {
        $this->message = $message;
        $this->user = $user;
        $this->type = $type;
        $this->package_name = $package_name;

        $data = [];
        if ($type === 'single'){
            $data['user'] = $user;
        }else{
            foreach ($user as $u){
                $data['users'][] = [
                    'id' => $u->id,
                    'company_name' => $u->company_name,
                    'email' => $u->email,
                    'phone' => $u->phone
                ];
            }
        }
        $this->data = $data;
    }



    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->message,
            'type' => $this->type,
            'package_name' => $this->package_name,
             ...$this->data
        ];
    }

}
