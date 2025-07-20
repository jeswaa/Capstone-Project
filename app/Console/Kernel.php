<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            Artisan::call('route:call', ['uri' => route('admin.update.rooms')]);
        })->dailyAt('00:01'); // Runs every midnight

        $schedule->call('App\Http\Controllers\StaffController@AutoCancellation')
                 ->dailyAt('00:00'); // Runs at midnight every day
        $schedule->command('autocancel:reservations')->everyMinute();
    }
    


    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
    protected $commands = [
        \App\Console\Commands\UpdateAccommodationStatus::class,
        \App\Console\Commands\AutoCancelReservations::class,
    ];
    
}
