<?php

namespace App\Notifications;

use App\Notifications\DatabaseChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotificationHandler extends Notification
{
    use Queueable;

    public $model;
    public $data;
    /**
     * Create a new notification instance.
     */
    public function __construct(Model $model, array $data)
    {
        $this->model = $model;
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [DatabaseChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Store notification to database
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'model_id' => $this->model->id,
            'model_type' => $this->model->getMorphClass(),
            'data' => $this->data,
        ];
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
