@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
@if (($SuhasSettings->show_images_in_email=='1' ) && ($SuhasSettings::setupCompleted()))

@if ($SuhasSettings->brand == '3')
@if ($SuhasSettings->logo!='')
    <img class="navbar-brand-img logo" src="{{ url('/') }}/uploads/{{ $SuhasSettings->logo }}">
@endif
{{ $SuhasSettings->site_name }}

@elseif ($SuhasSettings->brand == '2')
@if ($SuhasSettings->logo!='')
    <img class="navbar-brand-img logo" src="{{ url('/') }}/uploads/{{ $SuhasSettings->logo }}">
@endif
@else
{{ $SuhasSettings->site_name }}
@endif
@else
Asset-IT
@endif
@endcomponent
@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
@if($SuhasSettings::setupCompleted())
© {{ date('Y') }} {{ $SuhasSettings->site_name }}. All rights reserved.
@else
© {{ date('Y') }} Asset-IT. All rights reserved.
@endif

@if ($SuhasSettings->privacy_policy_link!='')
<a href="{{ $SuhasSettings->privacy_policy_link }}">{{ trans('admin/settings/general.privacy_policy') }}</a>
@endif

@endcomponent
@endslot
@endcomponent
