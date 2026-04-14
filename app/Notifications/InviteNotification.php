<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;
use App\Models\User;
use App\Models\LocalOffer;

class InviteNotification extends Notification
{
    public $sender;
    public $localOffer;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $sender, LocalOffer $localOffer)
    {
        $this->sender = $sender;
        $this->localOffer = $localOffer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $acceptUrl = URL::signedRoute('invites.accept', [
            'localOfferId' => $this->localOffer->id,
            'userId' => $notifiable->id
        ]);

        return (new MailMessage)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line($this->sender->name . ' has invited you to join a local offer.')
            ->line('Local: ' . $this->localOffer->local->name)
            ->line('Price to join: $' . number_format($this->localOffer->totalPrice, 2))
            ->action('Accept Invitation', $acceptUrl)
            ->line('Thank you for using Smart Organizer!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
