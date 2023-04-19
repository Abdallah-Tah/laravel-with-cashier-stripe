<form id="payment-form" action="{{ route('subscription.create') }}" method="POST">
    @csrf
    <input type="hidden" name="plan" id="plan" value="{{ $plan->id }}">

    <div class="mb-3">
        <label for="card-holder-name" class="form-label">{{ __('Name on the card') }}</label>
        <input type="text" name="name" id="card-holder-name" class="form-control"
            value="" placeholder="Name on the card" required>
    </div>

    <div class="mb-3">
        <label for="card-element" class="form-label">{{ __('Card') }}</label>
        <div id="card-element" class="form-control"></div>
    </div>

    <hr>
    <button type="submit" class="btn btn-primary" id="card-button"
        data-secret="{{ $intent->client_secret }}">Subscribe</button>
</form>
