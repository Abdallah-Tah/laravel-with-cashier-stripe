<?php

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Plan;

class InPersonPaymentRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $plan;

    public function __construct(User $user, Plan $plan)
    {
        $this->user = $user;
        $this->plan = $plan;
    }

    public function build()
    {
        return $this->subject('In-Person Payment Request for Subscription')
            ->markdown('emails.in_person_payment_request')
            ->with([
                'userName' => $this->user->name,
                'planName' => $this->plan->name,
                'planPrice' => number_format($this->plan->price / 100, 2),
            ]);
    }
}
