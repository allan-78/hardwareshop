@component('mail::message')
# Verify Your Email Address

Hi {{ $name }},

Thank you for registering with Hardware Shop! Please click the button below to verify your email address.

@component('mail::button', ['url' => $verificationUrl])
Verify Email Address
@endcomponent

If you did not create an account, no further action is required.

Thanks,<br>
{{ config('app.name') }}

<small>If you're having trouble clicking the "Verify Email Address" button, copy and paste the URL below into your web browser: {{ $verificationUrl }}</small>
@endcomponent