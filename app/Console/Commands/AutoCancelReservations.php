<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AutoCancelReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'autocancel:reservations';  

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically cancels unconfirmed reservations after 24 hour';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $controller = new \App\Http\Controllers\StaffController();
        $result = $controller->AutoCancellation();
        $this->info($result->getContent());
    }
}
