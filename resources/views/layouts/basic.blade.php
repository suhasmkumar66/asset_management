<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ ($SuhasSettings) && ($SuhasSettings->site_name) ? $SuhasSettings->site_name : 'Asset-IT' }}</title>


    <!-- Select2 -->
    <link rel="stylesheet" href="{{ url(asset('js/plugins/select2/select2.min.css')) }}">

    <link rel="stylesheet" href="{{ url(mix('css/dist/all.css')) }}">
    <link rel="shortcut icon" type="image/ico" href="{{ url(asset('favicon.ico')) }}">


    @if (($SuhasSettings) && ($SuhasSettings->header_color))
        <style>
        .main-header .navbar, .main-header .logo {
        background-color: {{ $SuhasSettings->header_color }};
        background: -webkit-linear-gradient(top,  {{ $SuhasSettings->header_color }} 0%,{{ $SuhasSettings->header_color }} 100%);
        background: linear-gradient(to bottom, {{ $SuhasSettings->header_color }} 0%,{{ $SuhasSettings->header_color }} 100%);
        border-color: {{ $SuhasSettings->header_color }};
        }
        .skin-blue .sidebar-menu > li:hover > a, .skin-blue .sidebar-menu > li.active > a {
        border-left-color: {{ $SuhasSettings->header_color }};
        }

        .btn-primary {
        background-color: {{ $SuhasSettings->header_color }};
        border-color: {{ $SuhasSettings->header_color }};
        }

        </style>

    @endif

    @if (($SuhasSettings) && ($SuhasSettings->custom_css))
        <style>
            {!! $SuhasSettings->show_custom_css() !!}
        </style>
    @endif

</head>

<body class="hold-transition login-page">

    @if (($SuhasSettings) && ($SuhasSettings->logo!=''))
        <center>
            <img id="login-logo" src="{{ url('/') }}/uploads/{{ $SuhasSettings->logo }}">
        </center>
    @endif
  <!-- Content -->
  @yield('content')



    <div class="text-center" style="padding-top: 100px;">
        @if (($SuhasSettings) && ($SuhasSettings->privacy_policy_link!=''))
        <a target="_blank" rel="noopener" href="{{  $SuhasSettings->privacy_policy_link }}" target="_new">{{ trans('admin/settings/general.privacy_policy') }}</a>
    @endif
    </div>

</body>

</html>
