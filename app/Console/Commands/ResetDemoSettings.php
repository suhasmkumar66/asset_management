<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use App\Models\Setting;
use App\Models\User;

class ResetDemoSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Assetit:demo-settings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will reset the Asset-IT demo settings back to default. ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $this->info('Resetting the demo settings.');
        $settings = Setting::first();
        $settings->per_page = 20;
        $settings->site_name = 'Asset-IT Asset Management Demo';
        $settings->auto_increment_assets = 1;
        $settings->logo = 'Asset-logo.png';
        $settings->alert_email = 'service@Asset-it.io';
        $settings->header_color = null;
        $settings->barcode_type = 'QRCODE';
        $settings->default_currency = 'USD';
        $settings->brand = 3;
        $settings->ldap_enabled = 0;
        $settings->full_multiple_companies_support = 1;
        $settings->alt_barcode = 'C128';
        $settings->skin = '';
        $settings->email_domain = 'Assetitapp.com';
        $settings->email_format = 'filastname';
        $settings->username_format = 'filastname';
        $settings->date_display_format = 'D M d, Y';
        $settings->time_display_format = 'g:iA';
        $settings->thumbnail_max_h = '30';
        $settings->locale = 'en';
        $settings->version_footer = 'on';
        $settings->support_footer = 'on';
        $settings->save();

        if ($user = User::where('username', '=', 'admin')->first()) {
            $user->locale = 'en';
            $user->save();
        }

        
    }

}
