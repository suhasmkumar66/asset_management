@component('mail::message')

{{ trans('mail.test_mail_text') }}

Thanks,<br>
    @if ($SuhasSettings->show_url_in_emails=='1')
        <p><a href="{{ url('/') }}">{{ $SuhasSettings->site_name }}</a></p>
    @else
        <p>{{ $SuhasSettings->site_name }}</p>
    @endif
@endcomponent
