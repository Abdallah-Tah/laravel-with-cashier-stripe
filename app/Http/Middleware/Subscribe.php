<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Subscribe
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $company = $user->company;
        if ($company) {
            $subscription = $user->subscription('default');
            $sameCompanyUsers = $company->users;

            // Check if all sub-users belong to the same company as the main user
            $allSubUsersBelongToCompany = $sameCompanyUsers->every(function ($subUser) use ($company) {
                return $subUser->company_id === $company->id;
            });

            // Check if the subscription is active and not null
            $subscriptionActive = $subscription && $subscription->valid();

            if (!$allSubUsersBelongToCompany) {
                // Redirect to an error page or show an error message
                return redirect()->route('error');
            } elseif (!$subscriptionActive && $subscription === null) {
                // Redirect to the subscription plan page
                return redirect()->route('plans.index');
            } elseif (!$subscriptionActive) {
                // Redirect to the subscription update or upgrade page
                return redirect()->route('subscription.update');
            }
        }

        return $next($request);
    }
}
