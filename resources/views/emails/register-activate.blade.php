@extends('emails/layouts/default')

@section('content')
<p>{{ trans('mail.hello') }} {{ $user->first_name }},</p>

<p>{{ trans('mail.welcome_to', ['web' => $SuhasSettings->site_name]) }} {{ trans('mail.click_to_confirm', ['web' => $SuhasSettings->site_name]) }}</p>

<p><a href="{{ $activationUrl }}">{{ $activationUrl }}</a></p>

<p>{{ trans('mail.best_regards') }}</p>

@if ($SuhasSettings->show_url_in_emails=='1')
    <p><a href="{{ url('/') }}">{{ $SuhasSettings->site_name }}</a></p>
@else
    <p>{{ $SuhasSettings->site_name }}</p>
@endif
@stop
