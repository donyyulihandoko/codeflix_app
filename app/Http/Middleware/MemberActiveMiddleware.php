<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class MemberActiveMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userlogin = Auth::user()->id;
        $activeMember = User::query()->find($userlogin)->hasMembershipPlan();

        if (!$activeMember) {
            return response()->redirectToRoute('subscribe.plans');
        } else {
            return $next($request);
        }
    }
}
