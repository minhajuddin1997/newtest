@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header',["url"=>""])
Swopers Account Notification
@endcomponent
@endslot

<h1></h1>
<h1>Congratulations!</h1>
<h1>Your Profile Is Created.</h1>
<h4>Your Login Credentials</h4>
<p><strong>Email: </strong> {{$email}}</p>
<p><strong>Password: </strong> {{$password}}</p>
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
@endcomponent
@endslot
@endcomponent
