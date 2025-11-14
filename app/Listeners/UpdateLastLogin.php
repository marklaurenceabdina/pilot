<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Database\Eloquent\Model;

class UpdateLastLogin
{
    public function handle(Login $event): void
    {
        $user = $event->user;

        if ($user instanceof Model) {
            $user->forceFill(['last_login' => now()])->save();
        }
    }
}
