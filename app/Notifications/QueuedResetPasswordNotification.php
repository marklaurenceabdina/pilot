<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Notifications\ResetPassword;

// The key is implementing "ShouldQueue"
class QueuedResetPasswordNotification extends ResetPassword implements ShouldQueue
{
    use Queueable;

    // This class now does everything the default ResetPassword notification does,
    // but it automatically gets queued thanks to the ShouldQueue interface.
}
