<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class SetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
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
        $token = Str::random(60); // Crie um token único para segurança
        // Armazenar token em um campo apropriado ou em cache

        $url = url('/set-password?token=' . $token); // Link para o formulário de definição de senha

        return (new MailMessage)
            ->subject('Defina sua senha')
            ->greeting('Olá, ' . $this->user->name)
            ->line('Você foi cadastrado com sucesso.')
            ->action('Definir Senha', $url)
            ->line('Por favor, clique no botão acima para definir sua nova senha.')
            ->line('Se você não criou uma conta, ignore este e-mail.');
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
