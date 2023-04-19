@extends('layouts.master')

@section('tab_tittle', 'Checkout')

@section('content')
    <div class="container">
        <div class="row mt-4 mb-4">
            <div class="col-md-8 order-md-1 justify-between">
                <h4 class="mb-3">{{ __('Selected Plan') }}</h4>
                <p class="text-muted mb-4 text-capitalize font-weight-bold">
                    {{ $selectedPlan->name }} - ${{ number_format($selectedPlan->price / 100, 2) }}/month</p>
                <h4 class="mb-3">{{ __('Payment Method') }}</h4>
                <div class="tabbable full-width-tabs">
                    <ul class="nav nav-tabs">
                        <li class="nav-item active">
                            <a class="nav-link" href="#creditCard" data-toggle="tab">{{ __('Credit Card') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#inPerson" data-toggle="tab">{{ __('Pay In Person') }}</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="creditCard">
                            <div class="card-body">
                                @include('stripe.stripe', ['planId' => $selectedPlan->id])
                            </div>
                        </div>
                        <div class="tab-pane" id="inPerson">
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
    <script>
        var navPillsAdjust = function() {
            $('.nav.nav-tabs').each(function() {
                var liGroup = $(this).children('li');
                var liLength = liGroup.length;
                liGroup.each(function() {
                    var liWidth = 100 / liLength - 1;
                    $(this).css({
                        'min-width': liWidth + '%',
                        'margin-left': '0px',
                        'margin-right': '0px'
                    });
                });
            });
        };

        $(document).ready(function() {
            navPillsAdjust();
        });
    </script>
@endsection
@push('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript">
        var stripe = Stripe("{{ env('STRIPE_KEY') }}");

        var elements = stripe.elements();

        var card = elements.create('card', {
            hidePostalCode: true,
            style: {
                base: {
                    iconColor: '#666EE8',
                    color: '#31325F',
                    lineHeight: '40px',
                    fontWeight: 300,
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSize: '15px',
                    '::placeholder': {
                        color: '#CFD7E0',
                    },
                },        },
    });

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    if (e.target.getAttribute('href') === '#creditCard') {
        if (!card) {
            card = elements.create('card', {
                hidePostalCode: true,
                style: {
                    base: {
                        iconColor: '#666EE8',
                        color: '#31325F',
                        lineHeight: '40px',
                        fontWeight: 300,
                        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                        fontSize: '15px',
                        '::placeholder': {
                            color: '#CFD7E0',
                        },
                    },
                },
            });

            card.mount('#card-element');

            card.on('change', function (event) {
                var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });
        }
    }
});


    card.mount('#card-element');

    card.on('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    var form = document.getElementById('payment-form');

    form.addEventListener('submit', function(event) {
        event.preventDefault();
        stripe.createToken(card).then(function(result) {
            if (result.error) {
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                stripeTokenHandler(result.token);
            }
        });
    });

    function stripeTokenHandler(token) {
        var form = document.getElementById('payment-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);
        form.submit();
    }
</script>
@endpush
