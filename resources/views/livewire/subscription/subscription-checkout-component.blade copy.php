@extends('layouts.master')

@section('tab_tittle', 'Checkout')

@section('content')
    <div class="container">
        <div class="row mt-4 mb-4">
            <div class="col-md-8 order-md-1">
                <h4 class="mb-3">{{ __('Selected Plan') }}</h4>
                <p>{{ $selectedPlan->name }} - ${{ number_format($selectedPlan->price / 100, 2) }}/month</p>
                <h4 class="mb-3">{{ __('Payment Method') }}</h4>
                <ul class="nav nav-pills nav-fill mb-3" id="payment-methods">
                    <li class="nav-item">
                        <a class="nav-link {{ $paymentMethod == 'creditCard' ? 'active' : '' }}"
                            wire:click="$set('paymentMethod', 'creditCard')">{{ __('Credit Card') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $paymentMethod == 'inPerson' ? 'active' : '' }}"
                            wire:click="$set('paymentMethod', 'inPerson')">{{ __('Pay In Person') }}</a>
                    </li>
                </ul>
                <hr class="mb-4">
                <form wire:submit.prevent="submit">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cardNumber">{{ __('Card Number') }}</label>
                            <input type="text" class="form-control" id="cardNumber" placeholder="" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="expiration">{{ __('Expiration') }}</label>
                            <input type="text" class="form-control" id="expiration" placeholder="MM/YY" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="cvv">{{ __('CVV') }}</label>
                            <input type="text" class="form-control" id="cvv" placeholder="" required>
                        </div>
                    </div>

                    <h4 class="mb-3">{{ __('Billing Address') }}</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="country">{{ __('Country') }}</label>
                            <select class="custom-select d-block w-100" id="country" required>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}" {{ $country->id == 1 ? 'selected' : '' }}>
                                        {{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="state">{{ __('State/Province') }}</label>
                            <input type="text" class="form-control" id="state" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="city">{{ __('City') }}</label>
                            <input type="text" class="form-control" id="city" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="postalCode">{{ __('Postal Code') }}</label>
                            <input type="text" class="form-control" id="postalCode" required>
                        </div>
                    </div>

                    <hr class="mb-4">
                    <button class="btn btn-primary btn-lg btn-block" type="submit"
                        wire:click="{{ $paymentMethod == 'creditCard' ? 'submit' : 'payInPerson' }}">{{ __('Subscribe') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
