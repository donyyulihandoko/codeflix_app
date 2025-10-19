<?php

namespace App\Jobs;

use App\Models\Membership;
use App\Services\MembershipService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Events\MembershipHasExpired;
use Illuminate\Bus\Batchable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckMembershipStatus implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 120;
    public $tries = 3;
    // private MembershipService $membershipService;

    /**
     * Create a new job instance.
     */
    // public function __construct(MembershipService $membershipService)
    // {
    //     $this->membershipService = $membershipService;
    // }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // $this->membershipService->membershipStatusCheck();
        Membership::query()->where('active', true)
            ->where('end_date', '<', now()->toDateString())
            ->chunk(100, function ($memberships) {
                foreach ($memberships as $membership) {
                    $membership->update(['active' => false]);
                }
                event(new MembershipHasExpired($membership));
            });
    }
}
