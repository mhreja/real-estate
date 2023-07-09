@component('mail::message')
# Hello, {{ $name }}
{{ $message }}

@if(isset($url))
@component('mail::button', ['url' => $url])
Click Here
@endcomponent
@endif

Thanks,<br>
{{ config('app.name') }}
@endcomponent
