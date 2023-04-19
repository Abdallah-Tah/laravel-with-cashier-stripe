@component('mail::message')
# Dear {{ $userName }},

Thank you for choosing the "{{ $planName }}" plan, priced at ${{ $planPrice }}/month. Our assistant will contact you soon to complete the payment and activate your subscription.

## What to expect?

- Our assistant will visit you at your provided address.
- Please prepare the payment in cash or check, payable to "Your Company Name".
- Once the payment is received, your subscription will be activated.

If you have any questions, please feel free to reply to this email.

Thank you for your support!

Sincerely,

{{ config('app.name') }} Team
@endcomponent
