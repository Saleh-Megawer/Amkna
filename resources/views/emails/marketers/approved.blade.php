@component('mail::message')

# Your Marketer Application Has Been Approved 🎉

Hello **{{ $user->full_name }}**,

We are pleased to inform you that your application to join our platform as a marketer has been approved.

## Login Details

**Email Address**

{{ $user->email }}

**Password**

{{ $password }}

@component('mail::button', ['url' => url('admin')])
Login to Your Account
@endcomponent

You can now start marketing properties and earning commissions through our platform.

Thanks,  
{{ config('app.name') }}

@endcomponent