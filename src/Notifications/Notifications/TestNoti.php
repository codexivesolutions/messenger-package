<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TestNoti extends Notification
{
    use Queueable;

    public $user;
    public $msg;
    public $type;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user,$msg,$type)
    {
        $this->user = $user;
        $this->msg = $msg;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['Database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'msg' => $this->msg,
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'type' => $this->type,
        ];
    }
}
