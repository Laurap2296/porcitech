<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AlertaPorciTech extends Notification
{
    use Queueable;

    protected string $titulo;
    protected string $mensaje;

    public function __construct(string $titulo, string $mensaje)
    {
        $this->titulo = $titulo;
        $this->mensaje = $mensaje;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('PorciTech - ' . $this->titulo)
            ->greeting('🔔 Alerta de PorciTech')
            ->line($this->mensaje)
            ->line('Se recomienda realizar la revisión correspondiente.')
            ->salutation('Sistema PorciTech');
    }
}