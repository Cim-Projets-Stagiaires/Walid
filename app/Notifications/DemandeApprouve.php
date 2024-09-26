<?php

namespace App\Notifications;

use App\Helpers\DocumentHelper;
use App\Models\Demande_de_stage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DemandeApprouve extends Notification
{
    use Queueable;
    protected $demande;

    /**
     * Create a new notification instance.
     */
    public function __construct(Demande_de_stage $demande)
    {
        $this->demande = $demande;
        
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
        /* $docPath = DocumentHelper::generateCharteDoc($this->demande); */
        return (new MailMessage)
            ->subject('Demande de stage approuvé')
            ->view('emails.demande_approved', ['demande' => $this->demande]);
            /* ->attach($docPath, [
                'as' => 'Charte_du_stagiaire.docx',
                'mime' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            ]); */
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
        ];
    }
}
