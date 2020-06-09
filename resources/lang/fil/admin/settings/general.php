<?php

return array(
    'ad'				        => 'Ang Aktibong Direktorya',
    'ad_domain'				    => 'Ang Aktibong Direktorya ng domain',
    'ad_domain_help'			=> 'Ito ay minsan kapareho ng iyong email domain, pero hindi permanente.',
    'admin_cc_email'            => 'CC Email',
    'admin_cc_email_help'       => 'If you would like to send a copy of checkin/checkout emails that are sent to users to an additional email account, enter it here. Otherwise leave this field blank.',
    'is_ad'				        => 'Ito ay isang server ng Aktibong Direktorya',
	'alert_email'				=> 'Magpadala ng mga alert sa',
	'alerts_enabled'			=> 'Ang Email Alerts ay Pinagana',
	'alert_interval'			=> 'Ang Alerts Threshold ay Mag-expire (sa iilang araw)',
	'alert_inv_threshold'		=> 'Ang Threshold ng Inventory Alert',
	'asset_ids'					=> 'Ang mga ID ng asset',
	'audit_interval'            => 'Ang Pagitan ng Audit',
    'audit_interval_help'       => 'Kung ikaw ay kinakailangan na regular na magbilang ng iyomg mga pag-aari, ilagay ang agwat sa buwan.',
	'audit_warning_days'        => 'Ang Warning Threshold ng Audit',
    'audit_warning_days_help'   => 'Mga ilang araw na makaadvans kami sa pagpaalala sa iyo kapag ang mga asset ay nakasaad na para sa pag-audit?',
	'auto_increment_assets'		=> 'Magsagawa ng mga ID para sa auto-incrementing na asset',
	'auto_increment_prefix'		=> 'Ang prefix (opsyonal)',
	'auto_incrementing_help'    => 'Paganahin muna ang ID ng auto-incrementing asset para i-set ito',
	'backups'					=> 'Mga backup',
	'barcode_settings'			=> 'Ang mga Setting sa Barcode',
    'confirm_purge'			    => 'I-kumperma ang Pag-purge',
    'confirm_purge_help'		=> 'I-enter ang tekstong "DELETE" sa kahon sa ibaba para i-purge ang mga nai-delete na mga rekord. Ang aksyon na ito ay hindi na pwedeng maibalik.',
	'custom_css'				=> 'I-custom ang CSS',
	'custom_css_help'			=> 'Mag-enter ng kahit anung kustom na mag-override ng CSS na nais mong gamitin. Wag isali ang &lt;style&gt;&lt;/style&gt; mga tag.',
    'custom_forgot_pass_url'	=> 'I-custom ang URL ng Pag-reset sa Password',
    'custom_forgot_pass_url_help'	=> 'Papalitan nito ang built-in ng nakalimutang URL ng password sa skreen ng log-in, kapaki-pakinabang upang magdirekta sa panloob o ang password reset functionality ng LDAP. Ito ay epektibong hindi magpagana ng lokal na gumagamit para sa punsyonalidad sa nakalimutang password.',
    'dashboard_message'			=> 'Áng Mensahi sa Dashboard',
    'dashboard_message_help'	=> 'Ang tekstong ito ay lilitaw sa dashboard para sa sinuman na mayroong permiso na tumingin sa dashboard.',
	'default_currency'  		=> 'Ang Default na Currency',
	'default_eula_text'			=> 'Ang Default na EULA',
  'default_language'			=> 'Ang Default na Linggwahe',
	'default_eula_help_text'	=> 'Maaari kang mag-ugnay ng kustom na EULAS sa partikular na mga katergorya ng asset.',
    'display_asset_name'        => 'Ipakita ang Pangalan ng Asset',
    'display_checkout_date'     => 'Ang Petsa ng Pag-checkout ay Ipakita',
    'display_eol'               => 'Ipakita sa table view ang EOL',
    'display_qr'                => 'Ang mga Square Codes ay Ipakita',
	'display_alt_barcode'		=> 'Ipakita ang 1D barcode',
	'barcode_type'				=> 'Ang Uri ng 2D Barcode',
	'alt_barcode_type'			=> 'Ang uri ng 1D barcode',
    'eula_settings'				=> 'Ang mga Setting ng EULA',
    'eula_markdown'				=> 'Ang EULA na ito ay nagpahintulot ng <a href="https://help.github.com/articles/github-flavored-markdown/">Github flavored na markdown</a>.',
    'footer_text'               => 'Ang Karagdagang Teksto ng Footer ',
    'footer_text_help'          => 'Ang tekstong ito ay lilitaw sa kanang bahagsi ng footer. Ang mga links ay pinapayagan gamit ang <a href="https://help.github.com/articles/github-flavored-markdown/">Github flavored na markdown</a>. Ang biak na mga Linya, mga header, mga imahi, atbp ay maaaring magsaad ng hindi inaasahang mga resulta.',
    'general_settings'			=> 'Ang Pangakalahatang mga Setting',
	'generate_backup'			=> 'Magsagawa ng Backup',
    'header_color'              => 'Ang Kulay ng Header',
    'info'                      => 'Ang mga settings na ito ay pwedeng magbigay paalam sa sa iyo na i-customise ng iilang mga speto ng iyong pag-iinstall.',
    'laravel'                   => 'Ang Laravel na Bersyon',
    'ldap_enabled'              => 'Pinagana ang LDAP',
    'ldap_integration'          => 'Ang integrasyon ng LDAP',
    'ldap_settings'             => 'Ang mga setting ng LDAP',
    'ldap_login_test_help'      => 'Mag-enter ng balidong LDAP username at password mula sa binatayang DN na iyong ibinatay sa itaas upang subukan kung ang iyong LDAP login ay maayos na nai-configure. DAPAT MO MUNANG I-SAVE ANG IYONG UPDATED NA MGA SETTING NG LDAP.',
    'ldap_login_sync_help'      => 'Ito ay susubok lamang sa LDAP na mag-sync nang maayos. Kapag ang iyong LDAP Authentication query ay hindi tama, ang mga gumagamit ay hindi parin makapag-login. DAPAT MO MUNANG I-SAVE ANG IYONG UPDATED NA MGA SETTING NG LDAP.',
    'ldap_server'               => 'Ang Serber ng LDAP',
    'ldap_server_help'          => 'Ito ay dapat na magsimula sa ldap:// (para sa hindi naka-encrypt or TLS) o ldaps:// (para sa SSL)',
	'ldap_server_cert'			=> 'Ang pagpapatibay sa sertipikasyon ng LDAP SSL',
	'ldap_server_cert_ignore'	=> 'Payagan ang hindi balidong Sertipiko ng SSL',
	'ldap_server_cert_help'		=> 'Piliin ang checkbox na ito kapag ikay ay gumagamit ng self signed na SSL cert at gutong tumanggap ng hindi balidong sertipiko ng SSL.',
    'ldap_tls'                  => 'Gumamit ng TLS',
    'ldap_tls_help'             => 'Ito ay dapat na mai-check lamang kung ikaw ay nagpapatakbo ng STARTTLS sa iyong serber ng LDAP. ',
    'ldap_uname'                => 'Ang Bind Username ng LDAP',
    'ldap_pword'                => 'Ang Bind Password ng LDAP',
    'ldap_basedn'               => 'Ang Bind DN ng Base',
    'ldap_filter'               => 'Ang Filter ng LDAP',
    'ldap_pw_sync'              => 'Ang Password Sync ng LDAP',
    'ldap_pw_sync_help'         => 'Alisan ng tsek ang kahon kapag hindi mo gustong magpanatili ng mga password sync ng LDAP sa lokal na mga password. Ang hindi pagpapagana nito ay nangangahulugang na ang iyong gumagamit ay maaaring hindi makapag-login kapag ang iyong serber ng LDAP ay hindi maabot sa iilang mga kadahilanan.',
    'ldap_username_field'       => 'Ang Field ng Username',
    'ldap_lname_field'          => 'Ang Huling Pangalan',
    'ldap_fname_field'          => 'Unang Pangalan ng LDAP',
    'ldap_auth_filter_query'    => 'Ang Authentication query ng LDAP',
    'ldap_version'              => 'Ang Bersyon ng LDAP',
    'ldap_active_flag'          => 'Ang Aktibong Flag ng LDAP',
    'ldap_emp_num'              => 'Ang Numero ng Empleyado ng LDAP',
    'ldap_email'                => 'Ang Email ng LDAP',
    'license'                  => 'Ang Lisensya ng Software',
    'load_remote_text'          => 'Ang Remote ng mga Iskrip',
    'load_remote_help_text'		=> 'Ang pag-install ng Asset-IT ay maaaring makapag load ng mga iskrip mula sa labas ng mundo.',
    'login_note'                => 'Ang Note sa Pag-login',
    'login_note_help'           => 'Opsyonal na maglakip ng iilang mga pangungusap sa iyong skreen, halimbawa upang makapaghatid ng tulong sa mga taong nakakita ng nawawala o ninakaw na device. Ang field na ito ay tumatanggap ng <a href="https://help.github.com/articles/github-flavored-markdown/">Github flavored na markdown</a>',
    'login_remote_user_text'    => 'Remote User login options',
    'login_remote_user_enabled_text' => 'Enable Login with Remote User Header',
    'login_remote_user_enabled_help' => 'This option enables Authentication via the REMOTE_USER header according to the "Common Gateway Interface (rfc3875)"',
    'login_common_disabled_text' => 'Disable other authentication mechanisms',
    'login_common_disabled_help' => 'This option disables other authentication mechanisms. Just enable this option if you are sure that your REMOTE_USER login is already working',
    'login_remote_user_custom_logout_url_text' => 'Custom logout URL',
    'login_remote_user_custom_logout_url_help' => 'If a url is provided here, users will get redirected to this URL after the user logs out of Asset-IT. This is useful to close the user sessions of your Authentication provider correctly.',
    'logo'                    	=> 'Ang Logo',
    'logo_print_assets'         => 'Use in Print',
    'logo_print_assets_help'    => 'Use branding on printable asset lists ',
    'full_multiple_companies_support_help_text' => 'Pagbabawal sa mga gumagamit (kasama ang mga admin) na nakatalaga sa mga asset ng kanilang kompanya.',
    'full_multiple_companies_support_text' => 'Ang Buong Suporta sa Maramihang Kompanya',
    'show_in_model_list'   => 'Ipakita sa Modelo ng mga Dropdowns',
    'optional'					=> 'opsyonal',
    'per_page'                  => 'Ang mga Resulta Bawat Pahina',
    'php'                       => 'Ang Bersyon ng PHP',
    'php_gd_info'               => 'Dapat kang mag-install ng php-gd para makapag-pakita ng mga code ng QR, tingnan ang mga batayan sa pag-install.',
    'php_gd_warning'            => 'Hindi na-install ang Pagpoproseso ng Imahe ng PHP at plugin ng GD.',
    'pwd_secure_complexity'     => 'Ang Pagkakumplikado ng Password',
    'pwd_secure_complexity_help' => 'Pumili sa alin mang patakaran sa pagkakumplikado ng password ang gusto mong ipatupad.',
    'pwd_secure_min'            => 'Ang minimum na mga karakter ng password',
    'pwd_secure_min_help'       => 'Ang minimum na pinahihintulutang balyu ay 5',
    'pwd_secure_uncommon'       => 'Iwasan ang karaniwang mga password',
    'pwd_secure_uncommon_help'  => 'Ito ay hindi magpayag sa mga user sa paggamit ng mga karaniwang password na nagmula sa top 10,000 na mga password na nai-report sa mga paglabag.',
    'qr_help'                   => 'Paganahin muna ang mga Codes ng QR sa pagtakda nito',
    'qr_text'                   => 'Ang Teksto ng Code ng QR',
    'setting'                   => 'Mga Setting',
    'settings'                  => 'Ang mga Setting',
    'show_alerts_in_menu'       => 'Ipakita ang mga alert sa itaas ng pagpipilian',
    'show_archived_in_list'     => 'Ang mga Asset na Naka-archive',
    'show_archived_in_list_text'     => 'Ipakita ang mga asset na naka-archive sa listahan ng "lahat ng mga asset"',
    'show_images_in_email'     => 'Show images in emails',
    'show_images_in_email_help'   => 'Uncheck this box if your Asset-IT installation is behind a VPN or closed network and users outside the network will not be able to load images served from this installation in their emails.',
    'site_name'                 => 'Ang Pangalan ng Site',
    'slack_botname'             => 'Ang Slack Botname',
    'slack_channel'             => 'Ang Slack Channel',
    'slack_endpoint'            => 'Ang Slack Endpoint',
    'slack_integration'         => 'Ang mga Setting ng Slack',
    'slack_integration_help'    => 'Ang integrasyon ng slack ay opsyonal, gayunpaman ang endpoint at channle ay kinakailangan kung nais mo itong gamitin. Para i-configure ang integrasyon ng Slack, ay kinakailangan mo munang<a href=":slack_link" target="_new">magsagawa ng papasok na webhook</a> sa iyong account sa Slack.',
    'slack_integration_help_button'    => 'Once you have saved your Slack information, a test button will appear.',
    'slack_test_help'           => 'Test whether your Slack integration is configured correctly. YOU MUST SAVE YOUR UPDATED SLACK SETTINGS FIRST.',
    'Suhas_version'  			=> 'Ang bersyon ng Asset-IT',
    'support_footer'            => 'Sumusuporta ng mga Link ng Footer ',
    'support_footer_help'       => 'I-specify kung sino ang nakakakita ng mga link sa impormasyon ng Asset-IT Support at ang mga User Manual',
    'version_footer'            => 'Version in Footer ',
    'version_footer_help'       => 'Specify who sees the Asset-IT version and build number.',
    'system'                    => 'Ang Impormasyon ng Sistema',
    'update'                    => 'Ang mga Setting ay I-update',
    'value'                     => 'Balyu',
    'brand'                     => 'Ang Pagkakaroon ng Brand',
    'about_settings_title'      => 'Ang Tungkol sa mga Setting',
    'about_settings_text'       => 'Ang mga setting na ito ay nagbibigay permiso sa pag-customize ng iilang aspeto sa iyong pag-install.',
    'labels_per_page'           => 'Ang mga label ng bawat pahina',
    'label_dimensions'          => 'Ang mga dimensyon ng label (pulgada)',
    'next_auto_tag_base'        => 'Ang sumusunod na auto-increment',
    'page_padding'              => 'Ang mga margin ng pahina (pulgada)',
    'privacy_policy_link'       => 'Link to Privacy Policy',
    'privacy_policy'            => 'Privacy Policy',
    'privacy_policy_link_help'  => 'If a url is included here, a link to your privacy policy will be included in the app footer and in any emails that the system sends out, in compliance with GDPR. ',
    'purge'                     => 'Ang mga Rekords na Nai-delete sa Pag-purge',
    'labels_display_bgutter'    => 'Mag-label sa ilalim ng gutter',
    'labels_display_sgutter'    => 'Mag-label sa gilid ng gutter',
    'labels_fontsize'           => 'Ang sukat ng font ng label',
    'labels_pagewidth'          => 'Mag-label sa lapad ng sheet',
    'labels_pageheight'         => 'Mag-label sa taas ng sheet',
    'label_gutters'        => 'Ang label sa pagitan (pulgada)',
    'page_dimensions'        => 'Ang mga dimensyon ng pahina (pulgada)',
    'label_fields'          => 'Mag-label sa bisibol na mga fields',
    'inches'        => 'pulgada',
    'width_w'        => 'w',
    'height_h'        => 'h',
    'show_url_in_emails'                => 'I-link ang Asset-IT sa mga Email',
    'show_url_in_emails_help_text'      => 'I-uncheck ang box na ito kung hindi mo gustong mag-link pabalik sa pag-install ng Asset-IT sa mga footers ng iyong email. Ito ay kapaki-pakinabang kung karamihan sa iyong mga gumagamit ay kailanman hindi mag-login. ',
    'text_pt'        => 'pt',
    'thumbnail_max_h'   => 'Ang maximum na taas ng thumbnail',
    'thumbnail_max_h_help'   => 'Ang maximum na taas sa mga pixels na kung saan ang mga thumbnails ay maaaring magpapakita ng view ng mga listahan. Min 25, max 500.',
    'two_factor'        => 'Ang Dalawang Factor ng Pag-authenticate',
    'two_factor_secret'        => 'Ang Two-Factor na Code',
    'two_factor_enrollment'        => 'Ang Two-Factor Enrollment',
    'two_factor_enabled_text'        => 'Paganahin ang Dalawang Factor',
    'two_factor_reset'        => 'I-reset ang Two-Factor na Sekreto',
    'two_factor_reset_help'        => 'Ito ay maaaring magpilit sa mga gumagamit na mag-enroll muli sa kanilang device gamit ang Google Authenticator. Ito ay maaaring kapaki-pakinabang kung ang kanilang na-enroll na device ay nawala o ninakaw. ',
    'two_factor_reset_success'          => 'Ang dalawang factor na device ay matagumpay na nai-reset',
    'two_factor_reset_error'          => 'Ang pag-reset sa dalawang factor na device ay hindi nagtagumpay',
    'two_factor_enabled_warning'        => 'Paganahin ang dalawang factor kapag ito ay kasalukuyang hindi pinagana ay maaari itong maghatid ng madalian na pagpilit na mag-authenticate gamit ang Google Auth sa na-enroll na device. Ikaw ay mayroong abilidad na i-enroll ang iyong device kapag may isa na hindi pa kasalukuyang naka-enroll.',
    'two_factor_enabled_help'        => 'Ito ay magpapagana sa two-factor authentication gamit ang Google Authenticator.',
    'two_factor_optional'        => 'Selektib (Maaaring paganahin o hindi pagaganahin ng mga gumagamit kung pahihintulutan)',
    'two_factor_required'        => 'Kinakailangan para sa lahat ng mga gumagamit',
    'two_factor_disabled'        => 'Huwag paganahin',
    'two_factor_enter_code'	=> 'I-enter ang Two-Factor Code',
    'two_factor_config_complete'	=> 'I-submit ang Code',
    'two_factor_enabled_edit_not_allowed' => 'Ang iyong tagapangasiwa ay hindi magpapahintulot sa iyo na i-edit ang mga setting na ito.',
    'two_factor_enrollment_text'	=> "Ang Two factor authentication ay kinakailangan, gayunpaman ang iyong device ay hindi ma na-enroll. Buksan mo ang itong Google Authenticator app at i-scan ang QR code sa ibaba para ma-enroll ang iyong device. Kapag na-enroll na ang device. i-enter ang code sa ibaba",
    'require_accept_signature'      => 'Nangangailangan ng Pag-lagda',
    'require_accept_signature_help_text'      => 'Sa pagpapagana ng katangian nito ay nangangailangan sa mga gumagamit na pisikal na mag-sign off sa pagtanggap ng isang asset.',
    'left'        => 'kaliwa',
    'right'        => 'kanan',
    'top'        => 'itaas',
    'bottom'        => 'ibaba',
    'vertical'        => 'bertikal',
    'horizontal'        => 'pahalang',
    'unique_serial'                => 'Unique serial numbers',
    'unique_serial_help_text'                => 'Checking this box will enforce a uniqueness constraint on asset serials',
    'zerofill_count'        => 'Ang haba ng mga tags ng asset, kabilang ang zerofill',
);
