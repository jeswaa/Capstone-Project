<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Accomodation;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UpdateAccommodationStatus extends Command
{
    protected $signature = 'accommodations:update-status';
    protected $description = 'Update accommodation status based on reservation check-out dates';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
{
    $expiredAccommodationIds = DB::table('reservation_details')
        ->where('reservation_check_out_date', '<', now()->toDateString())
        ->pluck('accomodation_id')
        ->toArray(); // Convert to array para sure na walang JSON encoding issue

    if (empty($expiredAccommodationIds)) {
        $this->info('No accommodations to update.');
        return;
    }

    $updatedCount = DB::table('accomodations')
        ->whereIn('accomodation_id', $expiredAccommodationIds)
        ->update(['accomodation_status' => 'available']);

    $this->info('Updated accommodations: ' . $updatedCount);
}

}
