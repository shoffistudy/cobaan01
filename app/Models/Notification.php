<?php

namespace App\Models;


use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{

    public function model()
    {
        return $this->morphTo();
    }
}
