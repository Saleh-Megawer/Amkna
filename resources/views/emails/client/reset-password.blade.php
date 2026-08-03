@component('mail::message')
# Reset Password

Hello,

You are receiving this email because we received a password reset request for your account.

@component('mail::button', ['url' => $url, 'color' => 'primary'])
Reset Password
@endcomponent

**This password reset link will expire in 60 minutes.**

If you did not request a password reset, no further action is required.

Regards,<br>
{{ config('app.name') }}

@component('mail::subcopy')
If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:
<span dir="ltr">{{ $url }}</span>
@endcomponent
@endcomponent
