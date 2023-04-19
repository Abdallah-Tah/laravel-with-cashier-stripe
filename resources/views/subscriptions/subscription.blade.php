@extends('layouts.master')

@section('tab_tittle', 'Plans')

@section('content')
    <div class="container">
        <div class="row mt-4 mb-4">
            <div class="col-md-8 order-md-1">
                <h4 class="mb-3">{{ __('Selected Plan') }}</h4>
                <p class="text-muted mb-4 text-capitalize fw-bold">
                    {{ $plan->name }} - ${{ number_format($plan->price / 100, 2) }}/month</p>
                <h4 class="mb-3 d-flex justify-content-center">{{ __('Payment Method') }}</h4>
                <div class="tabbable full-width-tabs">
                    <ul class="nav nav-tabs d-flex justify-content-center">
                        <li class="nav-item">
                            <a class="nav-link active" id="creditCard-tab" data-bs-toggle="tab" href="#creditCard">
                                {{ __('Credit Card') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="inPerson-tab" data-bs-toggle="tab" href="#inPerson">
                                {{ __('Pay In Person') }}
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content mt-3">
                        <div class="tab-pane active" id="creditCard" role="tabpanel" aria-labelledby="creditCard-tab">
                            <div class="card-body">
                                @include('stripe.stripe')
                            </div>
                        </div>
                        <div class="tab-pane" id="inPerson" role="tabpanel" aria-labelledby="inPerson-tab">
                            <h4 class="mb-3">{{ __('Pay In Person') }}</h4>
                            <p>To proceed with the In-Person payment, please click the button below. Our agent will contact
                                you to schedule a visit and collect the payment or check for your subscription. Once the
                                payment is collected, your subscription will be activated.</p>
                            <button class="btn btn-primary"
                                wire:click="payInPerson">{{ __('Request In-Person Payment') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('{{ env('STRIPE_KEY') }}')

        const elements = stripe.elements()
        const cardElement = elements.create('card')

        cardElement.mount('#card-element')

        const form = document.getElementById('payment-form')
        const cardBtn = document.getElementById('card-button')
        const cardHolderName = document.getElementById('card-holder-name')

        form.addEventListener('submit', async (e) => {
            e.preventDefault()

            cardBtn.disabled = true
            const {
                setupIntent,
                error
            } = await stripe.confirmCardSetup(
                cardBtn.dataset.secret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: {
                            name: cardHolderName.value
                        }
                    }
                }
            )

            if (error) {
                cardBtn.disable = false
            } else {
                let token = document.createElement('input')
                token.setAttribute('type', 'hidden')
                token.setAttribute('name', 'token')
                token.setAttribute('value', setupIntent.payment_method)
                form.appendChild(token)
                form.submit();
            }
        })
    </script>
@endsection
