<tr>
    <td class="header"{!!  ($SuhasSettings->header_color!='') ? ' style="background-color: '.e($SuhasSettings->header_color).'"' : '' !!}>
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
    </td>
</tr>
