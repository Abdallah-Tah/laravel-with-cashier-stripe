<?php

namespace App\Http\Controllers\Subscriptions;

use Stripe\Stripe;
use App\Models\Plan;
use Stripe\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlanController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        $plans = Plan::get();

        return view("subscriptions.plans", compact("plans"));
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function show(Plan $plan, Request $request)
    {
        $slug = $request->slug;

        $plan = Plan::where('slug', $slug)->first();

        $intent = auth()->user()->createSetupIntent();

        return view("subscriptions.subscription", compact("plan", "intent"));
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function subscription(Request $request)
    {
        $plan = Plan::find($request->plan);

        $user = auth()->user();

        $user->newSubscription('default', $plan->stripe_plan_id)->create($request->payment_method);

        return view("subscriptions.subscription_success");
    }
}
