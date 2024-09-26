<?php

namespace App\Notifications;

use App\Models\Rapport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RapportNonValider extends Notification
{
    use Queueable;
    protected $rapport;

    /**
     * Create a new notification instance.
     */
    public function __construct(Rapport $rapport)
    {
        $this->rapport = $rapport;
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
        return (new MailMessage)
        ->subject('Rapport Non Valider')
        ->view('emails.rapport_nv', ['rapport' => $this->rapport, 'stagiaire' => $this->rapport->stagiaire]);
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
