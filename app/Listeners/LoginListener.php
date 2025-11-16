<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LoginListener
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
    public function handle(object $event): void
    {
        $event->user->update([
            'last_login_time_232187' => date('Y-m-d H:i:s'),
            'last_login_ip_232187' => request()->getClientIp(),
        ]);
    }
}
