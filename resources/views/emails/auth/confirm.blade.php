@component('mail::message')
# Welcome to JymTube!

You have successfully registered to our system. Please activate your account.

@component('mail::button', ['url' => route('activate.user', $user->activation_code)])
Activate
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
