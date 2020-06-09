@extends('emails/layouts/default')

@section('content')
<p>{{ trans('mail.hello') }} {{ $user->first_name }},</p>

<p>{{ trans('mail.link_to_update_password', ['web' => $SuhasSettings->site_name]) }} </p>

<p><a href="{{ $forgotPasswordUrl }}">{{ $forgotPasswordUrl }}</a></p>

<p>{{ trans('mail.best_regards') }}</p>

@if ($SuhasSettings->show_url_in_emails=='1')
    <p><a href="{{ url('/') }}">{{ $SuhasSettings->site_name }}</a></p>
@else
    <p>{{ $SuhasSettings->site_name }}</p>
@endif
@stop
