@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
{{-- @if (trim($slot) === 'Laravel')
<img src="{{asset('frontend/images/logo.png')}}" class="logo" alt="Laravel Logo">
@else
{{ $slot }}
@endif --}}

<img src="{{asset('frontend/images/logo.png')}}" class="logo" alt="Laravel Logo">

</a>
</td>
</tr>
