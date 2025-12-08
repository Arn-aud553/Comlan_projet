<?php

namespace App\Notifications;

use App\Models\Contenu;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewContentNotification extends Notification
{
    use Queueable;

    public $contenu;

    /**
     * Create a new notification instance.
     */
    public function __construct(Contenu $contenu)
    {
        $this->contenu = $contenu;
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
            'contenu_id' => $this->contenu->id_contenu,
            'titre' => $this->contenu->titre,
            'auteur' => $this->contenu->auteur->name,
            'message' => 'Nouvelle publication en attente de validation.',
            'type' => 'publication'
        ];
    }
}
