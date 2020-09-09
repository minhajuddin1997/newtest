@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header',["url"=>""])
New Connection
@endcomponent
@endslot
<h1></h1>
<h1>New Connection</h1>
<p>The Company <strong>{{$company_name}}</strong> Send You A Request To Connect.</p>
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
@endcomponent
@endslot
@endcomponent
