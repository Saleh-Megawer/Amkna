@component('mail::message')

# Your Marketer Application Update

Hello **{{ $user->full_name }}**,

Thank you for your interest in joining our platform as a marketer.

After reviewing your application, we regret to inform you that we are unable to approve your request at this time.

@if(!empty($messageText))

## Review Notes

{{ $messageText }}

@endif

You are welcome to submit a new application in the future.

If you have any questions, please feel free to contact our support team.

Thanks,  
{{ config('app.name') }}

@endcomponent