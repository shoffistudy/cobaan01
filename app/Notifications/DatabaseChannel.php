<?php

namespace App\Notifications;

use Illuminate\Notifications\Channels\DatabaseChannel as ChannelsDatabaseChannel;
use Illuminate\Notifications\Notification;

class DatabaseChannel extends ChannelsDatabaseChannel
{
    /**
     * store notifications data to database
     */
    public function send($notifiable, Notification $notification)
    {
        $data = array_merge(
            $notification->toDatabase($notifiable),
            ['id' => $notification->id, 'type' => get_class($notification)],
        );

        return $notifiable->routeNotificationFor('database')->create($data);
    }
}
