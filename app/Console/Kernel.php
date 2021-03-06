<?php

namespace App\Console;

use App\Console\Commands\ImportLocations;
use App\Console\Commands\ReEncodeCustomFieldNames;
use App\Console\Commands\RestoreDeletedUsers;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->command('Assetit:inventory-alerts')->daily();
        $schedule->command('Assetit:expiring-alerts')->daily();
        $schedule->command('Assetit:expected-checkin')->daily();
        $schedule->command('Assetit:backup')->weekly();
        $schedule->command('backup:clean')->daily();
        $schedule->command('Assetit:upcoming-audits')->daily();
    }

    protected function commands()
    {
        require base_path('routes/console.php');
        $this->load(__DIR__.'/Commands');
    }
}
