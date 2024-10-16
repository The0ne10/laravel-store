<?php

namespace App\Listeners;

use App\Notifications\Auth\SendNewUserNotification;
use Illuminate\Auth\Events\Registered;

class SendEmailNewUserListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        $event->user->notify(new SendNewUserNotification());
    }
}
