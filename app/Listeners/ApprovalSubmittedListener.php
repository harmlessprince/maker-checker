<?php

namespace App\Listeners;

use App\Enums\UserRoles;
use App\Models\User;
use App\Notifications\RequestSubmittedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class ApprovalSubmittedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        Notification::send($this->admins(), new  RequestSubmittedNotification($event->approval));
    }

    private function admins()
    {
        return  User::where('role', UserRoles::ADMIN)->where('id', '<>', auth('sanctum')->id())->get();
    }
}
