<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification as Notifications;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class Notification extends Notifications
{
    use Queueable;

    protected $typeClassMap=[
        1=>'fa-users text-aqua',
        2=>'fa-warning text-yellow',
        3=>'fa-users text-red',
        4=>'fa-shopping-cart text-green'
    ];

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($type,$content,$url='')
    {
        $this->data = [
            'type'=>$type,
            'content'=>$content,
            'class'=>array_get($this->typeClassMap,$type),
            'url'=>$url
        ];

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return $this->data;
    }
}
