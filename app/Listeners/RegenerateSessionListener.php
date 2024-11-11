<?php

namespace App\Listeners;

use App\Events\AfterSessionRegenerated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RegenerateSessionListener
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
    public function handle(AfterSessionRegenerated $event): void
    {
        cart()->updateStorageId(
            old: $event->old,
            current: $event->current,
        );
    }
}
