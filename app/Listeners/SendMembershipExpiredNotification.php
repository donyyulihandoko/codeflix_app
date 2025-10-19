<?php

namespace App\Listeners;

use App\Events\MembershipHasExpired;
use App\Notifications\MembershipExpiredNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendMembershipExpiredNotification
{
    private MembershipHasExpired $membershipHasExpired;

    /**
     * Create the event listener.
     */
    public function __construct(MembershipHasExpired $membershipHasExpired)
    {
        $this->membershipHasExpired = $membershipHasExpired;
    }

    /**
     * Handle the event.
     */
    public function handle(MembershipHasExpired $event): void
    {
        $event->getMembership()
            ->user
            ->notify(new MembershipExpiredNotification($event->getMembership()));
        // $this->membershipHasExpired->getMembership()->notify();
    }
}
