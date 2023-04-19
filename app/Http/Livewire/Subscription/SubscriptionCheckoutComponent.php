<?php

namespace App\Http\Livewire\Subscription;

use Exception;
use Stripe\Stripe;
use App\Models\Plan;
use App\Models\Country;
use Livewire\Component;
use InPersonPaymentRequest;
use Illuminate\Support\Facades\Mail;

class SubscriptionCheckoutComponent extends Component
{
    public $paymentMethod;
    public $selectedPlan;
    public $countries;
    public $clientSecret;

    public function mount($planId)
    {
        $this->selectedPlan = Plan::find($planId);
        $this->countries = Country::all();

        $user = auth()->user();
        $intent = $user->createSetupIntent();
        $this->clientSecret = $intent->client_secret;
    }

    public function submit()
    {

        $user = auth()->user();
        $paymentMethod = $this->paymentMethod;
        $plan = $this->selectedPlan->stripe_plan_id;

        dd($user, $paymentMethod, $plan);

        // try {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Create or update the Stripe customer
        $stripeCustomer = $user->createAsStripeCustomer();

        // dd($stripeCustomer);

        // Attach the payment method to the customer
        $stripeCustomer->updateDefaultPaymentMethod($paymentMethod);

        // Create a new subscription for the user
        $stripeSubscription = $stripeCustomer->newSubscription('default', $plan)->create([
            'email' => $user->email,
        ]);

        // Get the payment method used for the subscription
        $stripePaymentMethod = $stripeSubscription->latestPayment()->paymentMethod;

        // Set the payment method ID on the user's model
        $user->update([
            'stripe_payment_method' => $stripePaymentMethod,
        ]);

        session()->flash('message', 'Subscription created successfully.');
        // } catch (Exception $e) {
        //     $this->addError('message', 'Error creating subscription. ' . $e->getMessage());
        //     return;
        // }
    }



    public function payInPerson()
    {
        dd('pay in person');
        $user = auth()->user();
        $plan = $this->selectedPlan;

        // Send an email to the user with the required information
        Mail::to($user->email)->send(new InPersonPaymentRequest($user, $plan));

        // Show a message to the user
        session()->flash('message', 'Our assistant will contact you to complete the payment.');
        return redirect()->to('/dashboard');
    }


    public function render()
    {
        return view('livewire.subscription.subscription-checkout-component')
            ->layout('layouts.master', [
                'title' => 'Checkout'
            ]);
    }
}
